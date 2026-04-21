<?php
session_start();
include "db.php";
include "totp.php";

/* ─────────────────────────────────────────────────────
   STEP 1 – Validate email + password
───────────────────────────────────────────────────── */
if (isset($_POST['login'])) {

    $email = trim($_POST['email']);
    $pass  = $_POST['password'];

    // FIX: prepared statement — no SQL injection
    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE email = ? LIMIT 1");
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($pass, $user['password'])) {

            if (!empty($user['totp_secret'])) {
                // Already enrolled → ask for OTP
                unset(
                    $_SESSION['2fa_setup_secret'],
                    $_SESSION['2fa_setup_id'],
                    $_SESSION['2fa_setup_email']
                );
                $_SESSION['2fa_pending_id']    = $user['id'];
                $_SESSION['2fa_pending_role']  = $user['role'];
                $_SESSION['2fa_pending_dept']  = $user['department'];
                $_SESSION['2fa_pending_email'] = $user['email'];
                $show2FA = true;

            } else {
                // First login → enroll 2FA (generate secret only once per session)
                if (empty($_SESSION['2fa_setup_secret'])) {
                    $_SESSION['2fa_setup_secret'] = TOTP::generateSecret();
                }
                $_SESSION['2fa_setup_id']    = $user['id'];
                $_SESSION['2fa_setup_email'] = $user['email'];

                $otpAuthUrl = TOTP::getOtpAuthUrl(
                    $user['email'],
                    $_SESSION['2fa_setup_secret']
                );
                $showSetup = true;
            }

        } else {
            $error = "Invalid Email or Password";
        }
    } else {
        $error = "Invalid Email or Password";
    }
}

/* ─────────────────────────────────────────────────────
   STEP 2A – Verify OTP (already enrolled users)
───────────────────────────────────────────────────── */
if (isset($_POST['verify_otp'])) {

    if (!isset($_SESSION['2fa_pending_id'])) {
        $error = "Session expired. Please log in again.";
    } else {
        $uid = (int) $_SESSION['2fa_pending_id'];

        $stmt2 = mysqli_prepare($conn, "SELECT totp_secret FROM users WHERE id = ? LIMIT 1");
        mysqli_stmt_bind_param($stmt2, 'i', $uid);
        mysqli_stmt_execute($stmt2);
        $r2  = mysqli_stmt_get_result($stmt2);
        $row = mysqli_fetch_assoc($r2);

        if (empty($row['totp_secret'])) {
            $error = "2FA not configured. Please contact admin.";
        } else {
            $submittedOtp = trim($_POST['otp_code'] ?? '');

            // FIX: real TOTP verify — not a fake length check
            if (TOTP::verify($row['totp_secret'], $submittedOtp)) {

                $_SESSION['user_id']    = $uid;
                $_SESSION['email']      = $_SESSION['2fa_pending_email'];
                $_SESSION['role']       = $_SESSION['2fa_pending_role'];
                $_SESSION['department'] = $_SESSION['2fa_pending_dept'];

                unset(
                    $_SESSION['2fa_pending_id'],
                    $_SESSION['2fa_pending_role'],
                    $_SESSION['2fa_pending_dept'],
                    $_SESSION['2fa_pending_email']
                );

                $redirect = ($_SESSION['role'] === 'admin')
                    ? 'admin_dashboard.php'
                    : 'user_dashboard.php';
                header("Location: $redirect");
                exit;

            } else {
                $otpError = "Invalid or expired code. Please try again.";
                $show2FA  = true;
            }
        }
    }
}

/* ─────────────────────────────────────────────────────
   STEP 2B – Confirm OTP during first-time setup
───────────────────────────────────────────────────── */
if (isset($_POST['confirm_setup'])) {

    if (!isset($_SESSION['2fa_setup_id'], $_SESSION['2fa_setup_secret'], $_SESSION['2fa_setup_email'])) {
        $error = "Session expired. Please log in again.";

    } else {
        $uid    = (int) $_SESSION['2fa_setup_id'];
        $secret = $_SESSION['2fa_setup_secret']; // always from session, never regenerated
        $email  = $_SESSION['2fa_setup_email'];

        $submittedOtp = trim($_POST['otp_code'] ?? '');

        // FIX: real TOTP verify
        if (TOTP::verify($secret, $submittedOtp)) {

            // Save secret to DB
            $stmt3 = mysqli_prepare($conn, "UPDATE users SET totp_secret = ? WHERE id = ?");
            mysqli_stmt_bind_param($stmt3, 'si', $secret, $uid);
            $updateOk = mysqli_stmt_execute($stmt3);

            if (!$updateOk) {
                $error      = "Database error: " . mysqli_error($conn);
                $otpAuthUrl = TOTP::getOtpAuthUrl($email, $secret);
                $showSetup  = true;

            } elseif (mysqli_stmt_affected_rows($stmt3) === 0) {
                $error = "Could not save 2FA secret. Please log in again.";

            } else {
                // Success — fetch user and log in
                $stmt4 = mysqli_prepare($conn, "SELECT * FROM users WHERE id = ? LIMIT 1");
                mysqli_stmt_bind_param($stmt4, 'i', $uid);
                mysqli_stmt_execute($stmt4);
                $user = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt4));

                $_SESSION['user_id']    = $user['id'];
                $_SESSION['email']      = $user['email'];
                $_SESSION['role']       = $user['role'];
                $_SESSION['department'] = $user['department'];

                unset(
                    $_SESSION['2fa_setup_id'],
                    $_SESSION['2fa_setup_secret'],
                    $_SESSION['2fa_setup_email']
                );

                $redirect = ($user['role'] === 'admin')
                    ? 'admin_dashboard.php'
                    : 'user_dashboard.php';
                header("Location: $redirect");
                exit;
            }

        } else {
            // Wrong code — rebuild QR from same session secret (don't regenerate)
            $otpAuthUrl = TOTP::getOtpAuthUrl($email, $secret);
            $showSetup  = true;
            $otpError   = "Invalid code. Please try again. Make sure your phone clock is accurate.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>ERP Secure Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<style>
* {
  margin: 0; padding: 0;
  box-sizing: border-box;
  font-family: 'Poppins', sans-serif;
}

body {
  height: 100vh;
  overflow: hidden;
  background: linear-gradient(270deg, #2563eb, #9333ea, #06b6d4, #22c55e);
  background-size: 800% 800%;
  animation: gradientMove 12s ease infinite;
}

@keyframes gradientMove {
  0%   { background-position: 0% 50%; }
  50%  { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}

.login-container {
  position: absolute;
  top: 70px;
  left: 0;
  width: 100%;
  height: calc(100vh - 70px);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 2;
}

.login-wrapper {
  width: 100%;
  max-width: 420px;
  position: relative;
}

.login-wrapper::before {
  content: "";
  position: absolute;
  inset: -4px;
  border-radius: 20px;
  background: conic-gradient(#2563eb, #9333ea, #06b6d4, #22c55e, #f59e0b, #ef4444, #2563eb);
  animation: rotate 6s linear infinite;
  filter: blur(2px);
  z-index: -1;
}

@keyframes rotate {
  100% { transform: rotate(360deg); }
}

.login-box {
  background: rgba(255,255,255,0.15);
  backdrop-filter: blur(18px);
  border-radius: 20px;
  padding: 28px 24px;
  text-align: center;
  box-shadow: 0 20px 50px rgba(0,0,0,.4);
  border: 1px solid rgba(255,255,255,.3);
  animation: fadeUp .5s ease;
}

@keyframes fadeUp {
  from { opacity: 0; transform: translateY(25px); }
  to   { opacity: 1; transform: translateY(0); }
}

.login-box h2 { color: #fff; margin-bottom: 6px; }

.subtitle {
  color: #e0e7ff;
  font-size: 13px;
  margin-bottom: 18px;
}

/* ── Input ── */
.input-group {
  position: relative;
  margin-bottom: 20px;
  text-align: left;
}

.input-group input {
  width: 100%;
  padding: 12px 12px 12px 40px;
  border-radius: 10px;
  border: none;
  outline: none;
  background: rgba(255,255,255,0.2);
  color: #fff;
  font-size: 14px;
}

.input-group input::placeholder { color: #cdd; }
.input-group input:focus { background: rgba(255,255,255,0.3); box-shadow: 0 0 10px rgba(255,255,255,.4); }

.input-group i {
  position: absolute;
  left: 12px;
  top: 50%;
  transform: translateY(-50%);
  color: #fff;
  font-size: 14px;
}

/* ── Button ── */
button {
  width: 100%;
  padding: 13px;
  border: none;
  border-radius: 10px;
  background: linear-gradient(135deg, #2563eb, #9333ea);
  color: #fff;
  cursor: pointer;
  font-size: 14px;
  font-weight: 600;
  transition: .3s;
}

button:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,0,0,.4); }
button:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }

/* ── Error ── */
.error, .error-2fa {
  margin-top: 12px;
  padding: 10px 14px;
  border-radius: 10px;
  font-size: 13px;
  background: rgba(239,68,68,0.25);
  color: #fecaca;
  border: 1px solid rgba(239,68,68,0.4);
}

/* ── 2FA / Setup scrollable box ── */
.twofa-box {
  max-height: 68vh;
  overflow-y: auto;
  padding-right: 4px;
}

.twofa-box::-webkit-scrollbar { width: 4px; }
.twofa-box::-webkit-scrollbar-thumb { background: #cbd5f5; border-radius: 10px; }

/* ── Step badge ── */
.step-badge {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  background: rgba(255,255,255,0.2);
  color: #fff;
  padding: 5px 14px;
  border-radius: 20px;
  font-size: 12px;
  font-weight: 600;
  margin-bottom: 10px;
}

/* ── QR section ── */
.qr-section {
  background: rgba(255,255,255,0.12);
  border-radius: 14px;
  padding: 14px;
  margin-bottom: 14px;
}

#qrcode {
  display: flex;
  justify-content: center;
  margin-bottom: 10px;
}

#qrcode canvas, #qrcode img {
  border-radius: 8px;
  border: 3px solid #fff;
}

#qrcode-fallback {
  display: none;
  color: #fca5a5;
  font-size: 12px;
  margin-bottom: 8px;
}

.qr-section p { font-size: 12px; color: #e0e7ff; margin-top: 6px; line-height: 1.7; }

/* ── Manual key ── */
.secret-key {
  background: rgba(255,255,255,0.15);
  border-radius: 8px;
  padding: 8px 12px;
  font-size: 12px;
  letter-spacing: 2px;
  color: #bfdbfe;
  word-break: break-all;
  margin-top: 8px;
  font-family: monospace;
}

/* ── OTP digit boxes ── */
.code-wrapper {
  display: flex;
  justify-content: center;
  gap: 8px;
  margin: 14px 0;
}

.code-wrapper input {
  width: 44px;
  height: 52px;
  border-radius: 10px;
  border: 2px solid rgba(255,255,255,0.3);
  background: rgba(255,255,255,0.15);
  color: #fff;
  text-align: center;
  font-size: 20px;
  font-weight: 700;
  outline: none;
  transition: .2s;
}

.code-wrapper input:focus {
  border-color: #60a5fa;
  background: rgba(255,255,255,0.25);
}

/* ── Timer ── */
.timer-row {
  text-align: center;
  color: #e0e7ff;
  font-size: 12px;
  margin-bottom: 10px;
}

.timer-circle {
  display: inline-block;
  width: 28px;
  height: 28px;
  line-height: 28px;
  border-radius: 50%;
  background: rgba(255,255,255,0.2);
  color: #fff;
  font-size: 12px;
  font-weight: 700;
  margin-right: 4px;
}

/* ── Back link ── */
.back-link {
  display: block;
  margin-top: 12px;
  color: #bfdbfe;
  font-size: 12px;
  cursor: pointer;
  text-decoration: underline;
}

@media (max-width: 480px) {
  .login-wrapper { max-width: 95%; }
  .code-wrapper input { width: 38px; height: 46px; font-size: 18px; }
}
</style>
</head>

<body>

<?php include 'header.php'; ?>

<div class="login-container">
<div class="login-wrapper">
<div class="login-box">

<!-- ══════════════════════════════════════════
     PANEL A – Email + Password
══════════════════════════════════════════ -->
<?php if (empty($show2FA) && empty($showSetup)): ?>

  <h2>ERP Secure Login</h2>
  <p class="subtitle">Sign in with your corporate credentials</p>

  <form method="POST">
    <div class="input-group">
      <i class="fa-solid fa-envelope"></i>
      <input type="email" name="email" placeholder="Email" required>
    </div>

    <div class="input-group">
      <i class="fa-solid fa-lock"></i>
      <input type="password" name="password" placeholder="Password" required>
    </div>

    <button name="login">
      <i class="fa-solid fa-right-to-bracket"></i> Login
    </button>

    <?php if (isset($error)): ?>
      <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
  </form>


<!-- ══════════════════════════════════════════
     PANEL B – OTP verify (already enrolled)
══════════════════════════════════════════ -->
<?php elseif (!empty($show2FA)): ?>

  <div class="twofa-box">
    <div class="step-badge"><i class="fa-solid fa-shield-halved"></i> Two-Factor Verification</div>
    <h2>Enter Your Code</h2>
    <p class="subtitle">Open Google Authenticator and enter the 6-digit code for <strong>ERP System</strong></p>

    <div class="timer-row">
      <span class="timer-circle" id="timerCircle">30</span>
      Code refreshes every 30 seconds
    </div>

    <form method="POST" id="otpForm">
      <div class="code-wrapper" id="digitBoxes">
        <input type="text" maxlength="1" class="digit" inputmode="numeric">
        <input type="text" maxlength="1" class="digit" inputmode="numeric">
        <input type="text" maxlength="1" class="digit" inputmode="numeric">
        <input type="text" maxlength="1" class="digit" inputmode="numeric">
        <input type="text" maxlength="1" class="digit" inputmode="numeric">
        <input type="text" maxlength="1" class="digit" inputmode="numeric">
      </div>
      <input type="hidden" name="otp_code" id="otp_hidden">

      <button type="submit" name="verify_otp" id="verifyBtn" disabled>
        <i class="fa-solid fa-unlock"></i> Verify &amp; Login
      </button>

      <?php if (isset($otpError)): ?>
        <div class="error-2fa"><?= htmlspecialchars($otpError) ?></div>
      <?php endif; ?>
    </form>

    <span class="back-link" onclick="window.location.reload()">← Back to login</span>
  </div>


<!-- ══════════════════════════════════════════
     PANEL C – First-time QR setup
══════════════════════════════════════════ -->
<?php elseif (!empty($showSetup)): ?>

  <div class="twofa-box">
    <div class="step-badge"><i class="fa-solid fa-qrcode"></i> Set Up 2FA</div>
    <h2>Secure Your Account</h2>
    <p class="subtitle">Scan this QR code once with Google Authenticator</p>

    <div class="qr-section">
      <div id="qrcode-fallback">QR code could not be generated. Use the manual key below.</div>
      <div id="qrcode"></div>
      <p>
        <strong>Step 1:</strong> Open <strong>Google Authenticator</strong><br>
        <strong>Step 2:</strong> Tap <strong>+</strong> → <strong>Scan a QR code</strong><br>
        <strong>Step 3:</strong> Point your camera at the QR code above
      </p>
      <p style="margin-top:8px;">Or enter this key manually:</p>
      <div class="secret-key"><?= htmlspecialchars($_SESSION['2fa_setup_secret'] ?? '') ?></div>
    </div>

    <div class="timer-row">
      <span class="timer-circle" id="timerCircle">30</span>
      Code refreshes every 30 seconds
    </div>

    <form method="POST" id="setupForm">
      <div class="code-wrapper" id="digitBoxes">
        <input type="text" maxlength="1" class="digit" inputmode="numeric">
        <input type="text" maxlength="1" class="digit" inputmode="numeric">
        <input type="text" maxlength="1" class="digit" inputmode="numeric">
        <input type="text" maxlength="1" class="digit" inputmode="numeric">
        <input type="text" maxlength="1" class="digit" inputmode="numeric">
        <input type="text" maxlength="1" class="digit" inputmode="numeric">
      </div>
      <input type="hidden" name="otp_code" id="otp_hidden">

      <button type="submit" name="confirm_setup" id="verifyBtn" disabled>
        <i class="fa-solid fa-lock"></i> Confirm &amp; Enable 2FA
      </button>

      <?php if (isset($otpError)): ?>
        <div class="error-2fa"><?= htmlspecialchars($otpError) ?></div>
      <?php endif; ?>
    </form>

    <span class="back-link" onclick="window.location.reload()">← Cancel</span>
  </div>

<?php endif; ?>

</div><!-- login-box -->
</div><!-- login-wrapper -->
</div><!-- login-container -->

<!-- ══════════════════════════════════════════
     SCRIPTS
══════════════════════════════════════════ -->
<script>
/* ── Digit boxes logic (shared by both OTP panels) ── */
const digits    = document.querySelectorAll('.digit');
const hidden    = document.getElementById('otp_hidden');
const verifyBtn = document.getElementById('verifyBtn');

function assembleCode() {
  let code = '';
  digits.forEach(d => code += d.value);
  if (hidden)    hidden.value = code;
  if (verifyBtn) verifyBtn.disabled = (code.length < 6);
}

digits.forEach((box, i) => {
  box.addEventListener('input', () => {
    box.value = box.value.replace(/\D/, '');
    assembleCode();
    if (box.value && i < digits.length - 1) digits[i + 1].focus();
  });

  box.addEventListener('keydown', e => {
    if (e.key === 'Backspace' && !box.value && i > 0) {
      digits[i - 1].focus();
      digits[i - 1].value = '';
      assembleCode();
    }
  });

  box.addEventListener('paste', e => {
    e.preventDefault();
    const pasted = (e.clipboardData || window.clipboardData)
                    .getData('text').replace(/\D/g, '').slice(0, 6);
    pasted.split('').forEach((ch, j) => { if (digits[j]) digits[j].value = ch; });
    assembleCode();
    digits[Math.min(pasted.length, digits.length - 1)].focus();
  });
});

if (digits.length) digits[0].focus();

/* ── 30-second countdown ── */
const circle = document.getElementById('timerCircle');
if (circle) {
  function startTimer() {
    const secs = 30 - (Math.floor(Date.now() / 1000) % 30);
    circle.textContent = secs;
  }
  startTimer();
  setInterval(startTimer, 1000);
}

/* ── QR code generation (setup panel only) ── */
const OTP_AUTH_URL = <?= json_encode($otpAuthUrl ?? '') ?>;

(function () {
  const container = document.getElementById('qrcode');
  const fallback  = document.getElementById('qrcode-fallback');
  if (!container || typeof QRCode === 'undefined' || !OTP_AUTH_URL) return;

  try {
    new QRCode(container, {
      text        : OTP_AUTH_URL,
      width       : 180,
      height      : 180,
      colorDark   : '#0b3c7a',
      colorLight  : '#ffffff',
      correctLevel: QRCode.CorrectLevel.M
    });
    if (fallback) fallback.style.display = 'none';
  } catch (e) {
    if (fallback) fallback.style.display = 'block';
  }
})();
</script>

</body>
</html>
