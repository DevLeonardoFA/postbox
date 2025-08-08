<?php

$aba_ativa = isset($_GET['aba']) ? sanitize_text_field($_GET['aba']) : 'geral';

?>

<div class="postbox-layout">

    <div class="wrap">

        <h1><?= __( 'Postbox Options', 'postbox' ) ?></h1>

        <h2 class="nav-tab-wrapper">
            <a href="?page=postbox&aba=geral" class="nav-tab <?php echo $aba_ativa == 'geral' ? 'nav-tab-active' : ''; ?>">Geral</a>
            <a href="?page=postbox&aba=opcoes" class="nav-tab <?php echo $aba_ativa == 'opcoes' ? 'nav-tab-active' : ''; ?>">Opções</a>
            <a href="?page=postbox&aba=avancado" class="nav-tab <?php echo $aba_ativa == 'avancado' ? 'nav-tab-active' : ''; ?>">Avançado</a>
        </h2>

        <form method="post">
            <?php
            // Conteúdo de cada aba
            switch ($aba_ativa) {
                case 'opcoes':
                    echo '<h2>Opções</h2>';
                    echo '<label><input type="checkbox" name="ativar_algo"> Ativar algo</label>';
                    break;

                case 'avancado':
                    echo '<h2>Configurações Avançadas</h2>';
                    echo '<p>Aqui vão as opções avançadas.</p>';
                    break;

                default:
                    echo '<h2>Geral</h2>';
                    echo '<p>Configurações gerais do plugin.</p>';
                    break;
            }

            submit_button('Salvar Configurações');
            ?>
        </form>

    </div>

</div>