<?php
/* Template pour les pages étudiants */
acf_form_head();
get_header('etudiant');
?>
    <main class="etudiant-content">
        <?php
        while (have_posts()) : the_post();
            the_content();
        endwhile;
        ?>
    </main>
<?php
get_footer('etudiant');
