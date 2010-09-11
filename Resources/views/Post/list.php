<ul class="forum_posts_list">
    <?php foreach ($posts as $post): ?>
    <li>
        <div class="metas">
            <div class="author">
                <?php if ($author = $post->getRawValue()->getAuthor()): ?>
                <img src="<?php echo $view['gravatar']->getUrl($author->getEmail(), 60) ?>" alt="" class="avatar" />
                <a href="<?php echo $view['forum']->urlForUser($author) ?>" class="username"><?php echo $author->getUsername() ?></a>
                <?php else: ?>
                <img src="<?php echo $view['gravatar']->getUrl(null, 60) ?>" alt="" class="avatar" />
                <span class="username">Anonymous</span>
                <?php endif ?>
            </div>
            <div class="date">
                <span class="createdAt"><?php echo $view['time']->ago($post->getCreatedAt()->getRawValue()) ?></span>
            </div>
        </div>
        <div class="content">
            <?php echo $view['markdown']->transform($post->getMessage()) ?>
        </div>
    </li>
    <?php endforeach ?>
</ul>