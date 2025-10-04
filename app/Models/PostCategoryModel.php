<?php

namespace App\Models;

use CodeIgniter\Model;

class PostCategoryModel extends Model
{
    protected $table = 'post_categories';
    protected $allowedFields = ['post_id', 'category_id'];
}
