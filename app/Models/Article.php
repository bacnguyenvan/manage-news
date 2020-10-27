<?php

namespace App\Models;

class Article extends AppModel {

    protected $table = 'article';

    public $primaryKey = 'article_id';

    public $fillable = [
        'title',
        'wrap_up',
        'wb_book_seq',
        'letter_body',
        'issue_date',
        'page',
        'booklet_class_id',
        'article_type',
        'search_target_flag',
        'not_viewable_flag',
        'updated_user_id',
        'src_basename',
        'release_flag'
    ];

    protected $guarded = [];

    protected $hidden = [];

    public function authors() {
    	return $this->belongsToMany(
    		Author::class, 
    		'article_author', 
            'article_id',
    		'author_id')->withTimeStamps();
    }

    public function articleClasses() {
    	return $this->belongsToMany(
    		ArticleClass::class, 
    		ArticleArticleClass::class, 
            'article_id',
    		'article_class_id')->withTimeStamps();
    }

    public function topics() {
        return $this->belongsToMany(
            Topic::class, 
            ArticleTopic::class, 
            'article_id',
            'topics_id')->withTimeStamps();
    }

    public function bookletClass() {
        return $this->belongsTo(
            BookletClass::class,
            'booklet_class_id',
            'booklet_class_id'
        );
    }

    public function contents() {
        return $this->hasMany(
            Content::class, 
            'article_id');
    }

    public function userReadArticles() {
        return $this->hasMany(
            ReadArticle::class, 
            'article_id');
    }

    public function bookstore() {
        return $this->hasOne(
            Bookstore::class,
            'book_seq',
            'wb_book_seq'
        );
    }
}
