<?php
// Ajouter une catégorie "Blocs custom" au-dessus des catégories natives
function add_custom_block_category($categories, $post)
{
    return array_merge(
        [
            [
                'slug'  => 'custom-blocks',
                'title' => '🛠️ Blocs custom',
                'icon'  => null, // Tu peux ajouter une icône si nécessaire
            ]
        ],
        $categories // Ajoute les catégories WordPress existantes après
    );
}
add_filter('block_categories_all', 'add_custom_block_category', 10, 2);


// Autoriser tous les blocs natifs + le bloc ACF personnalisé
function allow_custom_acf_block($allowed_blocks, $post)
{
    $core_blocks = WP_Block_Type_Registry::get_instance()->get_all_registered();
    $core_blocks = array_keys($core_blocks);

    // Ajouter le bloc personnalisé
    $core_blocks[] = 'acf/block-texte';

    return $core_blocks;
}
add_filter('allowed_block_types_all', 'allow_custom_acf_block', 10, 2);


// Déclarer un bloc Gutenberg avec ACF dans la catégorie "Blocs custom"
function register_acf_block_types()
{
    acf_register_block_type(array(
        'name'              => 'chiffres-cles',
        'title'             => 'Chiffres clés',
        'description'       => "Un bloc montrant des chiffres clés",
        'render_template'   => 'blocks/block-chiffres-cles.php',
        'category'          => 'custom-blocks', // Catégorie personnalisée
        'mode'              => 'preview',
        'supports'          => [
            'align'  => true,
            'anchor' => true,
            'html'   => false,
        ],
    ));

    acf_register_block_type(array(
        'name'              => 'texte-image-accueil',
        'title'             => 'Image texte accueil',
        'description'       => "Un bloc avec une image et du texte pour la page d'accueil",
        'render_template'   => 'blocks/block-image-texte-accueil.php',
        'category'          => 'custom-blocks', // Catégorie personnalisée
        'mode'              => 'preview',
        'supports'          => [
            'align'  => true,
            'anchor' => true,
            'html'   => false,
        ],
    ));

    acf_register_block_type(array(
        'name'              => 'portraits-slider',
        'title'             => 'Bloc - Speakers - slider - Ajout manuel',
        'description'       => "Un bloc permettant d'ajouter des speakers pour un événement",
        'render_template'   => 'blocks/block-portraits-slider-ajout-manuel.php',
        'category'          => 'custom-blocks', // Catégorie personnalisée
        'mode'              => 'preview',
        'supports'          => [
            'align'  => true,
            'anchor' => true,
            'html'   => false,
        ],
    ));


    acf_register_block_type(array(
        'name'              => 'derniere-newsletter',
        'title'             => 'Dernière newsletter - AUTO',
        'description'       => "Un bloc avec un lien vers la dernière newsletter. Les champs sont modifiables dans Options du sites -> Bloc newsletter",
        'render_template'   => 'blocks/block-last-newsletter.php',
        'category'          => 'custom-blocks', // Catégorie personnalisée
        'mode'              => 'preview',
        'supports'          => [
            'align'  => true,
            'anchor' => true,
            'html'   => false,
        ],
    ));

    acf_register_block_type(array(
        'name'              => 'text-dropdown',
        'title'             => 'Texte et éléments à dérouler à droite',
        'description'       => "Un bloc avec du texte et des éléments à dérouler à droite du texte",
        'render_template'   => 'blocks/block-text-dropdown-right.php',
        'category'          => 'custom-blocks', // Catégorie personnalisée
        'mode'              => 'preview',
        'supports'          => [
            'align'  => true,
            'anchor' => true,
            'html'   => false,
        ],
    ));

    acf_register_block_type(array(
        'name'              => 'text-image-contenu',
        'title'             => 'Texte et image gauche ou droite',
        'description'       => "Un bloc avec du texte et une image qui peut aller à gauche ou droite",
        'render_template'   => 'blocks/block-text-image-gauche-droite.php',
        'category'          => 'custom-blocks', // Catégorie personnalisée
        'mode'              => 'preview',
        'supports'          => [
            'align'  => true,
            'anchor' => true,
            'html'   => false,
        ],
    ));




    acf_register_block_type(array(
        'name'              => 'agenda',
        'title'             => 'Agenda',
        'description'       => "Un bloc pour afficher un agenda heure par heure",
        'render_template'   => 'blocks/block-agenda.php',
        'category'          => 'custom-blocks', // Catégorie personnalisée
        'mode'              => 'preview',
        'supports'          => [
            'align'  => true,
            'anchor' => true,
            'html'   => false,
        ],
    ));

    acf_register_block_type(array(
        'name'              => 'publications',
        'title'             => 'Publications par années',
        'description'       => "Un bloc pour afficher des publications par années",
        'render_template'   => 'blocks/block-publications.php',
        'category'          => 'custom-blocks', // Catégorie personnalisée
        'mode'              => 'preview',
        'supports'          => [
            'align'  => true,
            'anchor' => true,
            'html'   => false,
        ],
    ));


    acf_register_block_type(array(
        'name'              => 'program-components',
        'title'             => 'Composition du programme',
        'description'       => "Un bloc pour afficher les composantes d'un programme",
        'render_template'   => 'blocks/block-program-components.php',
        'category'          => 'custom-blocks', // Catégorie personnalisée
        'mode'              => 'preview',
        'supports'          => [
            'align'  => true,
            'anchor' => true,
            'html'   => false,
        ],
    ));



    acf_register_block_type(array(
        'name'              => 'portraits-slider-team-members',
        'title'             => 'Portraits slider team members - AUTO',
        'description'       => "Un bloc affichant les portraits des membres de l'équipe avec remontée automatique",
        'render_template'   => 'blocks/block-portraits-slider-team-members.php',
        'category'          => 'custom-blocks', // Catégorie personnalisée
        'mode'              => 'preview',
        'supports'          => [
            'align'  => true,
            'anchor' => true,
            'html'   => false,
        ],
    ));

    acf_register_block_type(array(
        'name'              => 'last-job-offers',
        'title'             => 'Last job offers - AUTO',
        'description'       => "Un bloc affichant les dernières offres d'emploi",
        'render_template'   => 'blocks/block-last-job-offers.php',
        'category'          => 'custom-blocks', // Catégorie personnalisée
        'mode'              => 'preview',
        'supports'          => [
            'align'  => true,
            'anchor' => true,
            'html'   => false,
        ],
    ));

    acf_register_block_type(array(
        'name'              => 'last-news',
        'title'             => 'Last news - AUTO',
        'description'       => "Un bloc affichant les dernières actu",
        'render_template'   => 'blocks/block-last-news.php',
        'category'          => 'custom-blocks', // Catégorie personnalisée
        'mode'              => 'preview',
        'supports'          => [
            'align'  => true,
            'anchor' => true,
            'html'   => false,
        ],
    ));

    acf_register_block_type(array(
        'name'              => 'portraits-slider-researchers-auto',
        'title'             => 'Portraits slider researchers - AUTO',
        'description'       => "Un bloc affichant les portraits des chercheurs de façon automatique",
        'render_template'   => 'blocks/block-portraits-slider-researchers.php',
        'category'          => 'custom-blocks', // Catégorie personnalisée
        'mode'              => 'preview',
        'supports'          => [
            'align'  => true,
            'anchor' => true,
            'html'   => false,
        ],
    ));

    acf_register_block_type(array(
        'name'              => 'job-offers',
        'title'             => 'Toutes les job offers (internship ou job) - AUTO',
        'description'       => "Un bloc affichant toutes les offres, intership ou job",
        'render_template'   => 'blocks/block-job-offers.php',
        'category'          => 'custom-blocks', // Catégorie personnalisée
        'mode'              => 'preview',
        'supports'          => [
            'align'  => true,
            'anchor' => true,
            'html'   => false,
        ],
    ));

    acf_register_block_type(array(
        'name'              => 'texte-image-bouton',
        'title'             => 'Texte - image (500x500) - bouton / pour la home',
        'description'       => "Un bloc affichant un image (500x500), du texte et un bouton / utilisé uniquement sur la home sur la maquette, mais peut être utilisé partout",
        'render_template'   => 'blocks/block-text-image-bouton.php',
        'category'          => 'custom-blocks', // Catégorie personnalisée
        'mode'              => 'preview',
        'supports'          => [
            'align'  => true,
            'anchor' => true,
            'html'   => false,
        ],
    ));


    acf_register_block_type(array(
        'name'              => 'texte-image-bouton-projet',
        'title'             => 'Texte - image (600x400) - bouton / pour la page projet',
        'description'       => "Un bloc affichant un image (600x400), du texte et un bouton / utilisé uniquement sur la home sur la maquette, mais peut être utilisé partout",
        'render_template'   => 'blocks/block-text-image-bouton-projet.php',
        'category'          => 'custom-blocks', // Catégorie personnalisée
        'mode'              => 'preview',
        'supports'          => [
            'align'  => true,
            'anchor' => true,
            'html'   => false,
        ],
    ));

    acf_register_block_type(array(
        'name'              => 'texte-boutons',
        'title'             => 'Texte - boutons',
        'description'       => "Un bloc affichant du texte et un ou plusieurs boutons",
        'render_template'   => 'blocks/block-text-boutons.php',
        'category'          => 'custom-blocks', // Catégorie personnalisée
        'mode'              => 'preview',
        'supports'          => [
            'align'  => true,
            'anchor' => true,
            'html'   => false,
        ],
    ));


    acf_register_block_type(array(
        'name'              => 'videos-challenges',
        'title'             => 'Vidéos - challenges + filtre - AUTO',
        'description'       => "Un bloc affichant les vidéos de type 'Challenges' avec un filtre",
        'render_template'   => 'blocks/block-videos-challenges.php',
        'category'          => 'custom-blocks', // Catégorie personnalisée
        'mode'              => 'preview',
        'supports'          => [
            'align'  => true,
            'anchor' => true,
            'html'   => false,
        ],
    ));

    acf_register_block_type(array(
        'name'              => 'three-challenges',
        'title'             => 'Bloc - trois challenges',
        'description'       => "Un bloc pour afficher les 3 challenges",
        'render_template'   => 'blocks/block-three-challenges.php',
        'category'          => 'custom-blocks', // Catégorie personnalisée
        'mode'              => 'preview',
        'supports'          => [
            'align'  => true,
            'anchor' => true,
            'html'   => false,
        ],
    ));

    acf_register_block_type(array(
        'name'              => 'liste-de-cartes-simples',
        'title'             => 'Bloc - Liste de cartes simples',
        'description'       => "Un bloc pour afficher des cartes simples (utilisés à la base pour les composantes du programme)",
        'render_template'   => 'blocks/block-liste-de-cartes-simples.php',
        'category'          => 'custom-blocks', // Catégorie personnalisée
        'mode'              => 'preview',
        'supports'          => [
            'align'  => true,
            'anchor' => true,
            'html'   => false,
        ],
    ));

    acf_register_block_type(array(
        'name'              => 'text-700px-image',
        'title'             => 'Bloc - Texte (700px) - Image',
        'description'       => "Un bloc affichant du texte (à 700px par défaut) et des images pour la page challenges, avec couleurs variables",
        'render_template'   => 'blocks/block-text-image-challenge-700.php',
        'category'          => 'custom-blocks', // Catégorie personnalisée
        'mode'              => 'preview',
        'supports'          => [
            'align'  => true,
            'anchor' => true,
            'html'   => false,
        ],
    ));

    acf_register_block_type(array(
        'name'              => 'archives-calls-for-master-grant',
        'title'             => 'Boutons archives calls for Master Grant',
        'description'       => "Un bloc affichant une liste de boutons vers les archives des 'Calls for master grant'",
        'render_template'   => 'blocks/block-archives-calls-for-master-grant.php',
        'category'          => 'custom-blocks', // Catégorie personnalisée
        'mode'              => 'preview',
        'supports'          => [
            'align'  => true,
            'anchor' => true,
            'html'   => false,
        ],
    ));

    acf_register_block_type(array(
        'name'              => 'call-for-master-call-for-phd',
        'title'             => 'Deux blocs "Call for master / Call for PHD"',
        'description'       => "Une section avec deux blocs : Call for master / Call for PHD",
        'render_template'   => 'blocks/block-call-for-master-call-for-phd.php',
        'category'          => 'custom-blocks', // Catégorie personnalisée
        'mode'              => 'preview',
        'supports'          => [
            'align'  => true,
            'anchor' => true,
            'html'   => false,
        ],
    ));


    acf_register_block_type(array(
        'name'              => 'all-news-or-events',
        'title'             => 'Toutes les news ou les événements - AUTO',
        'description'       => "Un bloc affichant toutes les news ou les événements du site avec un bouton 'charger davantage'",
        'render_template'   => 'blocks/block-all-news-or-event.php',
        'category'          => 'custom-blocks', // Catégorie personnalisée
        'mode'              => 'preview',
        'supports'          => [
            'align'  => true,
            'anchor' => true,
            'html'   => false,
        ],
    ));

    acf_register_block_type(array(
        'name'              => 'videos-slider',
        'title'             => 'Slider vidéos - AUTO',
        'description'       => "Un slider avec des vidéos avec le choix du type de vidéo",
        'render_template'   => 'blocks/block-slider-videos.php',
        'category'          => 'custom-blocks', // Catégorie personnalisée
        'mode'              => 'preview',
        'supports'          => [
            'align'  => true,
            'anchor' => true,
            'html'   => false,
        ],
    ));

    acf_register_block_type(array(
        'name'              => 'timeline',
        'title'             => 'Timeline',
        'description'       => "Une timeline dans un slider",
        'render_template'   => 'blocks/block-timeline.php',
        'category'          => 'custom-blocks', // Catégorie personnalisée
        'mode'              => 'preview',
        'supports'          => [
            'align'  => true,
            'anchor' => true,
            'html'   => false,
        ],
    ));


    acf_register_block_type(array(
        'name'              => 'our-former-researchers',
        'title'             => 'Our former researchers - AUTO',
        'description'       => "Un bloc affichant les anciens chercheurs (catégorie à cocher pour chaque chercheur)",
        'render_template'   => 'blocks/block-our-former-researchers.php',
        'category'          => 'custom-blocks', // Catégorie personnalisée
        'mode'              => 'preview',
        'supports'          => [
            'align'  => true,
            'anchor' => true,
            'html'   => false,
        ],
    ));

    acf_register_block_type(array(
        'name'              => 'text-dropdown-bottom',
        'title'             => 'Texte avec éléments à dérouler en dessous',
        'description'       => "Un bloc avec du texte et des éléments à dérouler sous le texte",
        'render_template'   => 'blocks/block-text-dropdown-bottom.php',
        'category'          => 'custom-blocks', // Catégorie personnalisée
        'mode'              => 'preview',
        'supports'          => [
            'align'  => true,
            'anchor' => true,
            'html'   => false,
        ],
    ));
    acf_register_block_type(array(
        'name'              => 'videos-fundamentals',
        'title'             => 'Vidéos - fundamentals - AUTO',
        'description'       => "Un bloc affichant les vidéos de type 'Fundamentals' avec un filtre",
        'render_template'   => 'blocks/block-videos-fundamentals.php',
        'category'          => 'custom-blocks', // Catégorie personnalisée
        'mode'              => 'preview',
        'supports'          => [
            'align'  => true,
            'anchor' => true,
            'html'   => false,
        ],
    ));
    acf_register_block_type(array(
        'name'              => 'block-text-center',
        'title'             => 'Bloc de texte centré',
        'description'       => "Un bloc de texte simple et centré",
        'render_template'   => 'blocks/block-text-center.php',
        'category'          => 'custom-blocks', // Catégorie personnalisée
        'mode'              => 'preview',
        'supports'          => [
            'align'  => true,
            'anchor' => true,
            'html'   => false,
        ],
    ));
    acf_register_block_type(array(
        'name'              => 'block-text-decale-800px',
        'title'             => 'Bloc de texte décalé 800px',
        'description'       => "Un bloc de texte de 800px décalé à gauche",
        'render_template'   => 'blocks/block-text-decale-800px.php',
        'category'          => 'custom-blocks', // Catégorie personnalisée
        'mode'              => 'preview',
        'supports'          => [
            'align'  => true,
            'anchor' => true,
            'html'   => false,
        ],
    ));
}


add_action('acf/init', 'register_acf_block_types');
