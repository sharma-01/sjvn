<?php
/**
 * Standalone TOTP helper – Google Authenticator compatible
 * No Composer, no external APIs required.
 */
class TOTP {

    public static function generateSecret(int $length = 32): string {
        $chars  = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $secret = '';
        $bytes  = random_bytes($length);
        for ($i = 0; $i < $length; $i++) {
            $secret .= $chars[ord($bytes[$i]) & 31];
        }
        return $secret;
    }

    private static function base32Decode(string $secret): string {
        $map      = array_flip(str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ234567'));
        $secret   = strtoupper($secret);
        $buffer   = 0;
        $bitsLeft = 0;
        $result   = '';
        foreach (str_split($secret) as $char) {
            if (!isset($map[$char])) continue;
            $buffer    = ($buffer << 5) | $map[$char];
            $bitsLeft += 5;
            if ($bitsLeft >= 8) {
                $bitsLeft -= 8;
                $result   .= chr(($buffer >> $bitsLeft) & 0xFF);
            }
        }
        return $result;
    }

    public static function getCode(string $secret, int $window = 0): string {
        $timeSlice = (int)floor(time() / 30) + $window;

        $key = self::base32Decode($secret);

        // FIX: cross-platform safe big-endian — works on Windows XAMPP + Linux
        // pack('J') is machine-dependent (little-endian on Windows = wrong codes)
        $time = chr(0) . chr(0) . chr(0) . chr(0) . pack('N', $timeSlice);

        $hash   = hash_hmac('sha1', $time, $key, true);
        $offset = ord($hash[19]) & 0x0F; // SHA1 is always 20 bytes

        $code = (
            ((ord($hash[$offset])   & 0x7F) << 24) |
            ((ord($hash[$offset+1]) & 0xFF) << 16) |
            ((ord($hash[$offset+2]) & 0xFF) <<  8) |
             (ord($hash[$offset+3]) & 0xFF)
        ) % 1000000;

        return str_pad((string)$code, 6, '0', STR_PAD_LEFT);
    }

    public static function verify(string $secret, string $otp): bool {
        $otp = trim($otp);
        // Check -1, 0, +1 windows = ±30 seconds clock skew tolerance
        foreach ([-1, 0, 1] as $w) {
            if (hash_equals(self::getCode($secret, $w), $otp)) return true;
        }
        return false;
    }

    // FIX: label must be "issuer:account" format for Google Authenticator
    public static function getOtpAuthUrl(string $label, string $secret, string $issuer = 'ERP System'): string {
        return 'otpauth://totp/' . rawurlencode($issuer . ':' . $label)
             . '?secret=' . $secret
             . '&issuer=' . rawurlencode($issuer)
             . '&algorithm=SHA1&digits=6&period=30';
    }
}
