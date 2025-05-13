        // Simple JavaScript to make the tabs work
        document.addEventListener('DOMContentLoaded', function () {
            const tabLinks = document.querySelectorAll('.nav-link');

            tabLinks.forEach(tabLink => {
                tabLink.addEventListener('click', function (e) {
                    e.preventDefault();

                    // Remove active class from all tabs
                    tabLinks.forEach(link => {
                        link.classList.remove('active');
                    });

                    // Add active class to clicked tab
                    this.classList.add('active');

                    // Get the target tab from href attribute
                    const targetId = this.getAttribute('href');

                    // Hide all tab panes
                    document.querySelectorAll('.tab-pane').forEach(pane => {
                        pane.classList.remove('show', 'active');
                    });

                    // Show the target tab pane
                    if (targetId && targetId !== '#') {
                        const targetPane = document.querySelector(targetId);
                        if (targetPane) {
                            targetPane.classList.add('show', 'active');
                        }
                    }
                });
            });

            // Toggle password visibility
            const eyeIcons = document.querySelectorAll('.bi-eye, .bi-eye-slash');
            eyeIcons.forEach(icon => {
                icon.addEventListener('click', function () {
                    const input = this.parentNode.previousElementSibling;
                    if (input.type === 'password') {
                        input.type = 'text';
                        this.classList.remove('bi-eye');
                        this.classList.add('bi-eye-slash');
                    } else {
                        input.type = 'password';
                        this.classList.remove('bi-eye-slash');
                        this.classList.add('bi-eye');
                    }
                });
            });
        });

        const myModal = document.getElementById('myModal')
        const myInput = document.getElementById('myInput')

        myModal.addEventListener('shown.bs.modal', () => {
            myInput.focus()
        })