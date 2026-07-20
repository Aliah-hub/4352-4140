        <script src="<?= base_url('js/chart.js') ?>"></script>
        
        <!-- Script Responsive Mobile -->
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            var topbar = document.querySelector('.topbar');
            var sidebar = document.querySelector('.sidebar');
            
            if (topbar && sidebar) {
                // Création du bouton hamburger
                var toggleBtn = document.createElement('button');
                toggleBtn.className = 'mobile-toggle';
                toggleBtn.innerHTML = '<i class="bi bi-list"></i>';
                
                var title = topbar.querySelector('.topbar-title');
                if (title) {
                    topbar.insertBefore(toggleBtn, title);
                    title.style.display = 'inline-block';
                    title.style.marginLeft = '12px';
                } else {
                    topbar.prepend(toggleBtn);
                }
                
                // Création de l'overlay
                var overlay = document.createElement('div');
                overlay.className = 'sidebar-overlay';
                document.body.appendChild(overlay);
                
                // Événements
                toggleBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    sidebar.classList.toggle('open');
                    overlay.classList.toggle('open');
                });
                
                overlay.addEventListener('click', function() {
                    sidebar.classList.remove('open');
                    overlay.classList.remove('open');
                });
            }
        });
        </script>
</body>
</html>