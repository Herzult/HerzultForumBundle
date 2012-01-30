<?php

namespace Herzult\Bundle\ForumBundle\Util;

use Herzult\Bundle\ForumBundle\Model\Category;
use Herzult\Bundle\ForumBundle\Router\ForumUrlGenerator;


class BreadcrumbHelper
{
    private $urlGenerator;
    private $breadCrumbs;
    private $translator;

    public function __construct(ForumUrlGenerator $urlGenerator, $breadCrumbs, $translator)
    {
        $this->urlGenerator = $urlGenerator;
        $this->breadCrumbs  = $breadCrumbs;
        $this->translator   = $translator;
    }

    public function generateForumTitleCrumb()
    {
        $this->breadCrumbs->addItem(
            $this->translator->trans('forum.title', array(), 'HerzultForumBundle'),
            $this->urlGenerator->urlForForum()
        );
        return $this;
    }

    public function generateCategoryBreadcrumbs(Category $category)
    {
        $categories = array();
        do{
            $categories[] = $category;
        }while(($category = $category->getParentCategory()) !== null);

        $categoryNum = count($categories);

        // Reversed, as we want the last parent, which in fact is the first category in hierarchy
        for($i = $categoryNum; $i > 0; $i--)
        {
            // We start with the count, the array is indexed by a base of 0, the count by 1 so we need to subtract 1.
            $currentIdx = $i - 1;

            // For last breadcrumb in the category overview.
            $this->breadCrumbs->addItem(
                $categories[$currentIdx]->getName(),
                $this->urlGenerator->urlForCategory($categories[$currentIdx], false)
            );
        }

        return $this;
    }
}