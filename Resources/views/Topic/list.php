<ul class="forum_topics_list">
<?php foreach ($topics as $topic): ?>
    <li class="topic">
        <div class="content">
            <a class="subject" href="<?php echo $view['forum']->urlForTopic($topic) ?>"><?php echo $topic->getSubject() ?></a>
        </div>
        <div class="metas">
            <span class="creation">Created <span class="createdAt"><?php echo $view['time']->ago($topic->getCreatedAt()) ?> by <span class="author">John Doe</span></span></span>
            | <span class="numReplies"><?php echo $topic->getNumReplies() . ' ' . ($topic->getNumReplies() > 1 ? 'replies' : 'reply') ?></span>
            | <a class="category" href="<?php echo $view['forum']->urlForCategory($topic->getCategory()) ?>"><?php echo $topic->getCategory()->getName() ?></a>
        </div>
    </li>
<?php endforeach ?>
</ul>