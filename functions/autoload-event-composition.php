<?php

/**
 * Auto-chargement de la composition "Evenement" pour Gutenberg
 * Spécialement adapté pour les blocs réutilisables WordPress
 */

// Script JavaScript pour Gutenberg
function gutenberg_event_composition_loader()
{
    global $pagenow;

    // Seulement sur les nouvelles pages event
    if ($pagenow !== 'post-new.php' || !isset($_GET['post_type']) || $_GET['post_type'] !== 'event') {
        return;
    }
?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            console.log('=== AUTO-CHARGEMENT GUTENBERG ACTIVÉ ===');

            // Ajouter un bouton de test
            addTestButton();

            // Auto-chargement après 3 secondes
            setTimeout(function() {
                console.log('Tentative d\'auto-chargement...');
                loadGutenbergComposition();
            }, 3000);

            function addTestButton() {
                var button = $('<button type="button" class="button button-primary" style="margin-left: 10px;">📝 Charger Composition Événement</button>');

                button.on('click', function(e) {
                    e.preventDefault();
                    console.log('Chargement manuel de la composition...');
                    loadGutenbergComposition();
                });

                // Ajouter le bouton après le titre
                if ($('.wp-heading-inline').length > 0) {
                    $('.wp-heading-inline').after(button);
                } else {
                    $('.wrap h1').first().after(button);
                }
            }

            function loadGutenbergComposition() {
                console.log('Début du chargement de la composition Gutenberg...');

                // Vérifier si Gutenberg est chargé
                if (typeof wp === 'undefined' || !wp.data) {
                    console.log('Gutenberg pas encore chargé, tentative via AJAX...');
                    loadViaAjax();
                    return;
                }

                // Vérifier si l'éditeur est vide
                var currentContent = wp.data.select('core/editor').getEditedPostContent();
                console.log('Contenu actuel:', currentContent);

                if (currentContent && currentContent.trim() !== '') {
                    console.log('L\'éditeur n\'est pas vide, annulation du chargement automatique');
                    return;
                }

                // Charger via l'API Gutenberg
                loadGutenbergBlock();
            }

            function loadGutenbergBlock() {
                console.log('Chargement via API Gutenberg...');

                // Utiliser l'API REST pour récupérer le bloc réutilisable "Evenement"
                wp.apiFetch({
                    path: '/wp/v2/blocks?search=Evenement&per_page=1'
                }).then(function(blocks) {
                    console.log('Blocs trouvés:', blocks);

                    if (blocks && blocks.length > 0) {
                        var eventBlock = blocks[0];
                        console.log('Bloc Evenement trouvé:', eventBlock);

                        // Parser le contenu du bloc pour obtenir les blocs individuels
                        var blockContent = eventBlock.content.rendered || eventBlock.content.raw;
                        console.log('Contenu du bloc:', blockContent);

                        // Parser le contenu en blocs normaux (non réutilisables)
                        var parsedBlocks = wp.blocks.parse(blockContent);
                        console.log('Blocs parsés:', parsedBlocks);

                        // Insérer les blocs individuels (modifiables) dans l'éditeur
                        wp.data.dispatch('core/block-editor').insertBlocks(parsedBlocks);

                        console.log('Blocs individuels insérés avec succès!');

                        // Notification de succès
                        wp.data.dispatch('core/notices').createNotice(
                            'success',
                            'Composition "Evenement" chargée avec succès! (Blocs modifiables)', {
                                isDismissible: true
                            }
                        );
                    } else {
                        console.log('Aucun bloc "Evenement" trouvé');
                        loadViaAjax(); // Fallback
                    }
                }).catch(function(error) {
                    console.error('Erreur lors du chargement:', error);
                    loadViaAjax(); // Fallback
                });
            }

            function loadViaAjax() {
                console.log('Chargement via AJAX...');

                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'load_gutenberg_event_composition',
                        post_id: getPostId(),
                        security: '<?php echo wp_create_nonce("load_gutenberg_composition"); ?>'
                    },
                    success: function(response) {
                        console.log('Réponse AJAX:', response);

                        if (response.success) {
                            alert('✅ Composition chargée avec succès! (Blocs modifiables)');

                            // Si on a un contenu, l'injecter
                            if (response.data.content) {
                                injectContent(response.data.content);
                            } else {
                                // Recharger la page pour voir les changements
                                window.location.reload();
                            }
                        } else {
                            alert('❌ Erreur: ' + (response.data || 'Erreur inconnue'));
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Erreur AJAX:', error);
                        alert('❌ Erreur de communication: ' + error);
                    }
                });
            }

            function injectContent(content) {
                // Injecter le contenu dans Gutenberg
                if (typeof wp !== 'undefined' && wp.data) {
                    try {
                        // Parser le contenu en blocs
                        var blocks = wp.blocks.parse(content);
                        console.log('Blocs parsés:', blocks);

                        // Insérer les blocs
                        wp.data.dispatch('core/block-editor').insertBlocks(blocks);

                        console.log('Contenu injecté dans Gutenberg!');
                    } catch (error) {
                        console.error('Erreur injection Gutenberg:', error);
                        // Fallback: recharger la page
                        window.location.reload();
                    }
                } else {
                    // Fallback pour l'éditeur classique
                    if (window.tinyMCE && window.tinyMCE.activeEditor) {
                        window.tinyMCE.activeEditor.setContent(content);
                    } else if ($('#content').length > 0) {
                        $('#content').val(content);
                    }
                }
            }

            function getPostId() {
                var postId = $('#post_ID').val() ||
                    $('input[name="post_ID"]').val() ||
                    (window.adminpage === 'post-new-php' ? 0 :
                        parseInt(window.location.search.match(/post=(\d+)/)?.[1] || 0));

                console.log('Post ID détecté:', postId);
                return postId;
            }
        });
    </script>
<?php
}
add_action('admin_footer', 'gutenberg_event_composition_loader');

// Handler AJAX pour Gutenberg
function handle_load_gutenberg_event_composition()
{
    // Vérifier la sécurité
    if (!wp_verify_nonce($_POST['security'], 'load_gutenberg_composition')) {
        wp_send_json_error('Sécurité: Nonce invalide');
        return;
    }

    $post_id = intval($_POST['post_id']);

    error_log("Tentative de chargement de composition Gutenberg pour post ID: $post_id");

    // Rechercher le bloc réutilisable "Evenement"
    $event_block = find_gutenberg_event_block();

    if (!$event_block) {
        wp_send_json_error('Bloc réutilisable "Evenement" non trouvé dans Gutenberg');
        return;
    }

    error_log("Bloc Evenement trouvé: " . $event_block->post_title . " (ID: " . $event_block->ID . ")");

    // Si pas de post ID, créer un nouveau post
    if (!$post_id) {
        $post_id = wp_insert_post(array(
            'post_type' => 'event',
            'post_status' => 'draft',
            'post_title' => 'Nouvel événement - ' . date('Y-m-d H:i:s')
        ));

        if (is_wp_error($post_id)) {
            wp_send_json_error('Erreur lors de la création du post');
            return;
        }

        error_log("Nouveau post créé avec ID: $post_id");
    }

    // Copier le contenu du bloc réutilisable
    $success = copy_gutenberg_block_content($event_block->ID, $post_id);

    if ($success) {
        wp_send_json_success(array(
            'message' => 'Composition Gutenberg appliquée avec succès',
            'post_id' => $post_id,
            'block_id' => $event_block->ID,
            'block_title' => $event_block->post_title,
            'content' => $event_block->post_content
        ));
    } else {
        wp_send_json_error('Erreur lors de la copie du contenu');
    }
}
add_action('wp_ajax_load_gutenberg_event_composition', 'handle_load_gutenberg_event_composition');

// Fonction pour trouver le bloc réutilisable "Evenement"
function find_gutenberg_event_block()
{
    $search_terms = array('Evenement', 'Événement', 'Event');

    foreach ($search_terms as $term) {
        $blocks = get_posts(array(
            'post_type' => 'wp_block',
            'title' => $term,
            'posts_per_page' => 1,
            'post_status' => 'publish'
        ));

        if (!empty($blocks)) {
            error_log("Bloc réutilisable trouvé: " . $blocks[0]->post_title . " (ID: " . $blocks[0]->ID . ")");
            return $blocks[0];
        }
    }

    error_log("Aucun bloc réutilisable trouvé avec les termes: " . implode(', ', $search_terms));
    return false;
}

// Fonction pour copier le contenu du bloc réutilisable
function copy_gutenberg_block_content($source_block_id, $target_post_id)
{
    $source_block = get_post($source_block_id);

    if (!$source_block || $source_block->post_type !== 'wp_block') {
        error_log("Bloc source invalide: $source_block_id");
        return false;
    }

    // Récupérer le contenu du bloc réutilisable
    $block_content = $source_block->post_content;

    if (empty($block_content)) {
        error_log("Contenu du bloc vide pour ID: $source_block_id");
        return false;
    }

    // IMPORTANT: Copier le contenu brut (pas de référence au bloc réutilisable)
    // Cela permet de modifier les blocs individuellement

    // Mettre à jour le post avec le contenu brut
    $result = wp_update_post(array(
        'ID' => $target_post_id,
        'post_content' => $block_content  // Contenu brut, pas de référence
    ));

    if (is_wp_error($result)) {
        error_log("Erreur lors de la mise à jour du post: " . $result->get_error_message());
        return false;
    }

    error_log("Contenu brut copié avec succès du bloc $source_block_id vers le post $target_post_id");
    return true;
}

// Hook pour appliquer automatiquement lors de la création (alternative)
function auto_apply_gutenberg_composition_on_new_event($post_id, $post, $update)
{
    // Ne pas exécuter lors des mises à jour
    if ($update) {
        return;
    }

    // Vérifier le type de post
    if ($post->post_type !== 'event') {
        return;
    }

    // Vérifier que c'est bien un nouveau post vide
    if (!empty($post->post_content)) {
        return;
    }

    // Éviter la récursion
    remove_action('wp_insert_post', 'auto_apply_gutenberg_composition_on_new_event');

    // Appliquer la composition
    $event_block = find_gutenberg_event_block();
    if ($event_block) {
        copy_gutenberg_block_content($event_block->ID, $post_id);
    }

    // Remettre le hook
    add_action('wp_insert_post', 'auto_apply_gutenberg_composition_on_new_event', 10, 3);
}
add_action('wp_insert_post', 'auto_apply_gutenberg_composition_on_new_event', 10, 3);

// Ajouter une fonction de debug pour lister les blocs réutilisables
function debug_list_reusable_blocks()
{
    if (isset($_GET['debug_gutenberg']) && $_GET['debug_gutenberg'] === '1') {
        echo '<div class="wrap"><h1>Blocs réutilisables Gutenberg</h1>';

        $blocks = get_posts(array(
            'post_type' => 'wp_block',
            'posts_per_page' => -1,
            'post_status' => 'publish'
        ));

        if (!empty($blocks)) {
            echo '<ul>';
            foreach ($blocks as $block) {
                echo "<li><strong>ID:</strong> {$block->ID} - <strong>Titre:</strong> {$block->post_title}</li>";
            }
            echo '</ul>';
        } else {
            echo '<p>Aucun bloc réutilisable trouvé</p>';
        }

        echo '</div>';
        return;
    }
}
add_action('admin_init', 'debug_list_reusable_blocks');

// Ajouter le lien de debug dans le menu
function add_gutenberg_debug_menu()
{
    if (current_user_can('manage_options')) {
        add_submenu_page(
            'tools.php',
            'Debug Gutenberg',
            'Debug Gutenberg',
            'manage_options',
            'debug-gutenberg',
            function () {
                echo '<div class="wrap">';
                echo '<h1>Debug Gutenberg</h1>';
                echo '<p><a href="' . admin_url('tools.php?page=debug-gutenberg&debug_gutenberg=1') . '" class="button">Lister les blocs réutilisables</a></p>';
                echo '<p><a href="' . admin_url('post-new.php?post_type=event') . '" class="button button-primary">Tester création événement</a></p>';
                echo '</div>';
            }
        );
    }
}
add_action('admin_menu', 'add_gutenberg_debug_menu');
?>