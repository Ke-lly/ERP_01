document.addEventListener("DOMContentLoaded", function() {
    const navLinks = document.querySelectorAll('.sidebar .nav-link');
    const indicator = document.getElementById('indicator');

    navLinks.forEach(function(link) {
        link.addEventListener('click', function() {
            // Remove a classe ativa de todos os links
            navLinks.forEach(function(link) {
                link.classList.remove('active');
            });
            
            // Adiciona a classe ativa apenas ao link clicado
            this.classList.add('active');

        

            // Move o indicador para o link clicado
            this.appendChild(indicator);
            
        });
    });
});