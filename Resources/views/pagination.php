<?php if(!$pager->pageCount) return ?>
<p class="pagination">
    <?php if(isset($pager->previous)): ?>
    <a class="previous" href="<?php echo $url.'?page='.$pager->previous ?>">&laquo; Previous</a>
    <?php else: ?>
    <span class="previous inactive">&laquo; Previous</span>
    <?php endif ?>
    <?php foreach ($pager->pagesInRange as $page): ?>
    <?php if ($page != $pager->current): ?>
    <a class="page" href="<?php echo $url.'?page='.$page; ?>"><?php echo $page; ?></a>
    <?php else: ?>
    <span class="page current"><?php echo $page; ?></span>
    <?php endif; ?>
    <?php endforeach ?>
    <?php if(isset($pager->next)): ?>
    <a class="next" href="<?php echo $url.'?page='.$pager->next ?>">Next &raquo;</a>
    <?php else: ?>
    <span class="next inactive">Next &raquo;</span>
    <?php endif ?>
</p>
