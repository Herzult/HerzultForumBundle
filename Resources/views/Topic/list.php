<ul class="forum_topics_list">
<?php foreach ($topics as $topic): ?>
    <li class="topic">
        <div class="content">
            <a class="subject" href="<?php echo $view['forum']->urlForTopic($topic->getRawValue()) ?>"><?php echo $topic->getSubject() ?></a>
        </div>
        <div class="metas">
            <span class="creation">Created <span class="createdAt"><?php echo $view['time']->ago($topic->getCreatedAt()->getRawValue()) ?></span> by
            <?php if ($author = $topic->getAuthor()): ?>
                <a class="author" href="<?php echo $view['forum']->urlForUser($author) ?>"><?php echo $author->getUsername() ?></a>
            <?php else: ?>
                <span class="author">Anonymous</span>
            <?php endif ?>
            </span>
            | <span class="numPosts"><?php echo $topic->getNumPosts() . ' ' . ($topic->getNumPosts() > 1 ? 'posts' : 'post') ?></span>
            | <a class="category" href="<?php echo $view['forum']->urlForCategory($topic->getRawValue()->getCategory()) ?>"><?php echo $topic->getCategory()->getName() ?></a>
        </div>
    </li>
<?php endforeach ?>
</ul>
