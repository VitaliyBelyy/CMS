<aside class="sidebar">
    <div class="sidebar__widget">
        <h3 class="sidebar__widget-title">Розділи</h3>
        <ul class="sidebar__widget-list">
            <?php foreach ( $results['sections'] as $section ) { ?>
            <li class="sidebar__widget-list-item">
                <a href=".?action=archive&amp;sectionId=<?php echo $section->id ?>" class="sidebar__widget-list-link"><?php echo htmlspecialchars( $section->name ) ?></a>
            </li>
            <?php } ?>
        </ul>
    </div>
</aside>