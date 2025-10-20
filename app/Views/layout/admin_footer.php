<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<!-- Admin Scripts -->
<script>
    // Auto-hide alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });
    });

    // Active sidebar highlighting
    document.addEventListener('DOMContentLoaded', function() {
        const currentPath = window.location.pathname;
        const navLinks = document.querySelectorAll('.nav-link');

        navLinks.forEach(link => {
            if (link.getAttribute('href') === currentPath) {
                link.classList.add('active', 'text-primary', 'fw-bold');
            }
        });
    });
</script>

<script>
    document.addEventListener('click', function(e) {
        if (e.target && e.target.id === 'print-button') {
            const pathParts = window.location.pathname.split('/');
            const year = pathParts[pathParts.length - 2];
            const month = pathParts[pathParts.length - 1];
            window.open(`<?= base_url('admin/analytics/monthly-report-print/') ?>${year}/${month}`, '_blank');
        }
    });
</script>

</body>

</html>