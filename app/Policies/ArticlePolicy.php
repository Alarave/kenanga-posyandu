<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;

class ArticlePolicy
{
    /**
     * Determine if the user can view any articles.
     */
    public function viewAny(User $user): bool
    {
        return true; // Everyone can view
    }

    /**
     * Determine if the user can create articles.
     */
    public function create(User $user): bool
    {
        // Only Superadmin and potentially high-level admins can manage articles
        return $user->isSuperAdmin() || $user->isAdmin();
    }

    /**
     * Determine if the user can update the article.
     */
    public function update(User $user, Article $article): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Admins can edit their own articles or any if superadmin
        return $user->isAdmin() && $user->id === $article->user_id;
    }

    /**
     * Determine if the user can delete the article.
     */
    public function delete(User $user, Article $article): bool
    {
        // ONLY Superadmin can delete
        return $user->isSuperAdmin();
    }
}
