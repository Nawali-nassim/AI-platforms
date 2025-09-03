document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.validate-username').forEach(function(input) {
        input.addEventListener('input', function() {
            var pattern = /^[A-Za-z0-9_@#&-]+$/;
            if (!pattern.test(this.value)) {
                this.setCustomValidity('Username can only contain English letters, numbers, and _ @ # & - characters.');
            } else {
                this.setCustomValidity('');
            }
        });
    });
    const menuToggle = document.querySelector('.menu-toggle');
    const menu = document.querySelector('nav ul');
    if (menuToggle && menu) {
        menuToggle.addEventListener('click', () => {
            menu.classList.toggle('active');
        });
    }
});