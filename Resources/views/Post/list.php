<ul class="forum_posts_list">
    <?php foreach ($posts as $post): ?>
    <li>
        <div class="metas">
            Posted <span class="createdAt"><?php echo $view['time']->ago($post->getCreatedAt()->getRawValue()) ?></span>
            by <span class="author">John Doe</span>
        </div>
        <div class="content">
            <?php echo $view['markdown']->transform($post->getMessage()) ?>
        </div>
    </li>
    <?php endforeach ?>
</ul>