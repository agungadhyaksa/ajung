<?php

class ViewHelper {
    public static function escape(?string $str): string {
        return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8');
    }

    public static function setFlash(string $type, string $message): void {
        $_SESSION['flash_' . $type] = $message;
    }

    public static function getFlash(string $type): ?string {
        $key = 'flash_' . $type;
        if (isset($_SESSION[$key])) {
            $msg = $_SESSION[$key];
            unset($_SESSION[$key]);
            return $msg;
        }
        return null;
    }

    public static function statusBadge(string $status): string {
        $status = strtolower($status);
        switch ($status) {
            case 'active':
                return '<span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800">Aktif</span>';
            case 'pending':
                return '<span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-800">Menunggu</span>';
            case 'completed':
                return '<span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Selesai</span>';
            default:
                return '<span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">' . htmlspecialchars(ucfirst($status)) . '</span>';
        }
    }
}
