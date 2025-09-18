<?php
require_once get_template_directory() . '/blocks/options.php';

$options = get_block_options();
$style = $options['style'] ?? '';
$bgColor = $options['bgColor'] ?? '';
if (isset($bgColor)) {
    $bgColor = 'bg-' . $bgColor;
}

$class = $bgColor;

$titre = get_field('titre');

$horaires = get_field('horaires');


?>
<div style="<?= esc_attr($style) ?>" class="block-agenda wp-block-acf <?= esc_html($class) ?>">
    <div class="block">
        <?php if ($titre): ?>
            <h2><?= esc_html($titre) ?></h2>
        <?php endif; ?>

        <div class="print-agenda-container">
            <div id="print-agenda">
                <img class="imprimante" src="<?= get_template_directory_uri() . '/assets/png/imprimante.png' ?>" alt="">
                Imprimer l'agenda
            </div>
        </div>

        <table>
            <tbody>
                <?php
                if (!empty($horaires) && is_array($horaires)):
                    foreach ($horaires as $horaire):

                        $heure = $horaire['heure'] ?? '';
                        $description = $horaire['description'] ?? '';
                ?>
                        <tr>
                            <td><?= esc_html($heure) ?></td>
                            <td><?= wp_kses_post($description ?? '') ?></td>
                        </tr>
                <?php
                    endforeach;
                endif; ?>
            </tbody>
        </table>
        <div class="flou">
            <div class="deco-container">
                <img class="deco" src="<?= get_template_directory_uri() . '/assets/png/descendre.png' ?>" alt="">
            </div>
        </div>
    </div>
</div>


<script>
    document.getElementById('print-agenda').addEventListener('click', function() {
        // Récupère la table
        const table = document.querySelector('.block-agenda table');

        if (!table) return;

        // Ouvre une nouvelle fenêtre
        const printWindow = window.open('', '', 'width=800,height=600');

        // Contenu HTML à injecter dans la fenêtre
        printWindow.document.write(`
        <html>
        <head>
            <title>Agenda</title>
            <style>
                body {
                    font-family: sans-serif;
                    padding: 20px;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                }
                td, th {
                    border: 1px solid #000;
                    padding: 8px;
                }
            </style>
        </head>
        <body>
            <h2>Agenda</h2>
            ${table.outerHTML}
        </body>
        </html>
    `);

        printWindow.document.close();
        printWindow.focus();

        // Attendre que le contenu soit prêt avant d'imprimer
        printWindow.onload = () => {
            printWindow.print();
            printWindow.close();
        };
    });
</script>