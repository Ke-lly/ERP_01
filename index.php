
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!--NÃO ALTERAR-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Funcionários</title>
    <link rel="stylesheet" href="src/css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="src/css/styles.css">
</head>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <style>
       
    :root {
        --bg-purple: #4A148C;
        --deep-purple: #3c096c;
        --text-white: #fff;
        --border-color: #ddd;
    }
    
    .container {
        width: 100%;
        max-width: 800px;
        padding: 20px;
        background-color: white;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        margin-bottom: 20px;
    }
    h2 {
        font-weight: 500;
        color: white;
        text-align: center;
    }
    form {
        display: flex;
        flex-direction: column;
        gap: 15px;
        align-items: center;
    }
    .form-group, .mb-3 {
        display: flex;
        flex-direction: column;
        width: 100%;
        max-width: 600px;
        text-align: left;
    }
    input, select {
        padding: 10px;
        font-size: 1rem;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background-color: #f9f9f9;
        width: 100%;
    }
    button {
        padding: 12px;
        font-size: 1rem;
        color: var(--text-white);
        background-color: var(--bg-purple);
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 500;
        transition: background-color 0.3s ease;
        width: 100%;
        max-width: 600px;
        margin-top: 20px;
    }
    button:hover {
        background-color: var(--deep-purple);
    }
    .table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    th, td {
        padding: 14px;
        text-align: center;
        border: 1px solid var(--border-color);
    }
    th {
        background-color: var(--bg-purple);
        color: var(--text-white);
    }
    td {
        background-color: #f9f9f9;
    }
    .bg-purple {
        background-color: var(--bg-purple) !important; /* Fundo roxo para o sidebar */
    }
</style>
<style>:root {
    --bg-purple: #4A148C;
    --depp-purple: #3c096c;
    --text-white: #fff;
    --font-size-logo: 1.5rem;
    --font-weight-bold: bold;
    --font-size-base: 0.875rem;
    --padding-top-sidebar: 0; /* Alinhamento ao topo */
    --margin-bottom-logo: 20px;
    --icon-size-small: 16px;
    --icon-size-medium: 24px;
    --icon-size-large: 32px;
}

body {
    font-size: var(--font-size-base);
}

.sidebar {
    background-color: var(--bg-purple);
    height: auto;
    padding-top: var(--padding-top-sidebar);
}

.sidebar .logo {
    position: relative;
    text-align: center;
    color: var(--text-white);
    font-size: var(--font-size-logo);
    font-weight: bolder;
    padding: 15px;
    margin: 0;
    margin-left: -15px;
    width: 100%; /* Largura relativa */
    max-width: 100%; /* Garantir que a logo não exceda a largura do contêiner */
    background-color: var(--deep-purple); /* Corrigi a cor: deep-purple em vez de depp-purple */
}

.sidebar .nav-link {
    color: var(--text-white);
    font-weight: 500;
    display: flex;
    align-items: center;
    margin-top: 15px;
}

.sidebar .nav-link.active {
    color: var(--text-white);
}

/* Estilo para o indicador (seta) */
.sidebar .nav-link.active .indicator {
    margin-left: auto;
}


.sidebar .nav-link:not(.active):hover {
    background-color: var(--depp-purple);
    border-radius: 15px;
}

.sidebar .nav-link span {
    margin-left: 10px;
}

.sidebar-sticky {
    position: -webkit-sticky;
    position: sticky;
    top: 0;
    height: calc(100vh - 48px);
    padding-top: 0.5rem;
    overflow-x: hidden;
    overflow-y: auto;
}

.form-group label {
    font-weight: var(--font-weight-bold);
}

/* Personalização de tamanho dos ícones */
.icon-small {
    font-size: var(--icon-size-small);
}

.icon-medium {
    font-size: var(--icon-size-medium);
}

.icon-large {
    font-size: var(--icon-size-large);
}

.user{
    list-style-type: none;
    margin-top: 40px;
    margin-left: 15px;
    color: var(--text-white);
}
.card-user{
    background-color: var(--depp-purple);
    padding-left: 10px;
    width: 140px;
    padding-top: 4px;
    padding-bottom: 4px;
    border-radius: 15px;
}

.users{
    font-size: var(--icon-size-large);
}

.flex{
    display: flex;
    gap: 17px;
}

.flex .form-group select,
.flex .form-group input{
    width: 600px;
}

.btn-primary{
    margin-top: 2%;
    margin-left: 0%;
    width: 100%;
    background-color: var(--bg-purple);
    border-color: var(--depp-purple);
}

.btn-primary:hover{
    background-color: var(--depp-purple);
    border-color: var(--bg-purple);
}

.btn-danger{
    margin-top: 2%;
    width: 100%;
}

.main-form{
    margin-top: 5%;
    margin-left: 0%;
}

label{
    font-size: 20px;
}

.main-title{
    margin-bottom: 4%;
}

.card{
    margin-bottom: 4%;
}

.btn-create{
    margin-bottom: 1%;
}

@media (max-width: 1200px) {
    .sidebar .logo {
        font-size: calc(var(--font-size-logo) * 0.9); /* Ajuste o tamanho da fonte */
        padding: 12px;
    }
}

@media (max-width: 992px) {
    .sidebar .logo {
        font-size: calc(var(--font-size-logo) * 0.8); /* Ajuste o tamanho da fonte */
        padding: 10px;
    }
}

@media (max-width: 768px) {
    .sidebar .logo {
        font-size: calc(var(--font-size-logo) * 0.7); /* Ajuste o tamanho da fonte */
        padding: 8px;
    }
}

@media (max-width: 576px) {
    .sidebar .logo {
        font-size: calc(var(--font-size-logo) * 0.6); /* Ajuste o tamanho da fonte */
        padding: 6px;
    }
}</style>
</head>

<body>
    <!--NÃO ALTERAR-->
    <div class="container-fluid">
        <div class="row">
              <nav class="col-md-2 d-none d-md-block bg-purple sidebar">
                <div class="logo text-center py-4">
                   
                    <h2>HORIZON+</h2>
                </div>
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="produtos.php">
                               
                                <i class="bi bi-phone-fill icon-large"></i>
                                <span>Produtos</span>
                             
                            </a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="pedidos.php"><i class="bi bi-basket2-fill icon-large"></i> Pedidos</a></li>
                        <li class="nav-item"><a class="nav-link" href="fornecedores.php"><i class="bi bi-people-fill icon-large"></i> Fornecedores</a></li>
                        <li class="nav-item"><a class="nav-link" href="funcionarios.php"><i class="bi bi-person-badge-fill icon-large"></i> Funcionários</a></li>
                        <li class="nav-item"><a class="nav-link" href="estoque.php"><i class="bi bi-box-fill icon-large"></i> Estoque</a></li>
                        <li class="nav-item"><a class="nav-link" href="manutencao.php"><i class="bi bi-pc-display-horizontal icon-large"></i> Manutenção</a></li>
                    </ul>
                    <div class="user mt-4">
                        <div class="nav-item text-center">
                            <div class=>
                                
                                <div class="ml-2">
                                 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
            <!--NÃO ALTERAR-->

           
            


                <!--MEXER AQUI -->
                <!--NÃO ALTERAR-->
            </main>
        </div>
    </div>
    <!--NÃO ALTERAR-->
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script type='text/javascript' src='//code.jquery.com/jquery-compat-git.js'></script>
    <script type='text/javascript' src='//igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js'></script>
    <script src="script.js"></script>
    <!--NÃO ALTERAR-->
</body>

</html>
