// Interaktivitas UI Ajung Portal

document.addEventListener('DOMContentLoaded', () => {
    // Auto-dismiss alert notifikasi setelah 5 detik
    const alerts = document.querySelectorAll('.bg-emerald-50, .bg-rose-50');
    if (alerts.length > 0) {
        setTimeout(() => {
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s ease-out';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    }
});
