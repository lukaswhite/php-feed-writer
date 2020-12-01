<?php


namespace Lukaswhite\FeedWriter\Data\Itunes;


class Categories implements \JsonSerializable
{
    /**
     * @return array
     */
    public function all()
    {
        return [
            'Arts' => [
                'label' => 'Arts',
                'children' => [
                    'Books' => ['label' => $this->translate('Books')],
                    'Design' => ['label' => $this->translate('Design')],
                    'Fashion &amp; Beauty' => ['label' => $this->translate('Fashion and Beauty')],
                    'Food' => ['label' => $this->translate('Food')],
                    'Performing Arts' => ['label' => $this->translate('Performing Arts')],
                    'Visual Arts' => ['label' => $this->translate('Visual Arts')],
                ]
            ],
            'Business' => [
                'label' => 'Business',
                'children' => [
                    'Careers' => ['label' => $this->translate('Careers')],
                    'Entrepreneurship' => ['label' => $this->translate('Entrepreneurship')],
                    'Investing' => ['label' => $this->translate('Investing')],
                    'Management' => ['label' => $this->translate('Management')],
                    'Marketing' => ['label' => $this->translate('Marketing')],
                    'Non-Profit' => ['label' => $this->translate('Non-Profit')],
                ],
            ],
            'Comedy' => [
                'label' => $this->translate('Comedy'),
                'children' => [
                    'Comedy Interviews' => ['label' => $this->translate('Comedy Interviews')],
                    'Improv' => ['label' => $this->translate('Improv')],
                    'Stand-Up' => ['label' => $this->translate('Stand-Up')],
                ],
            ],
            'Education' => [
                'label' => $this->translate('Education'),
                'children' => [
                    'Courses' => ['label' => $this->translate('Courses')],
                    'How To' => ['label' => $this->translate('How To')],
                    'Language Learning' => ['label' => $this->translate('Language Learning')],
                    'Self-Improvement' => ['label' => $this->translate('Self-Improvement')],
                ],
            ],
            'Fiction' => [
                'label' => $this->translate('Fiction'),
                'children' => [
                    'Comedy Fiction' => ['label'=>$this->translate('Comedy Fiction')],
                    'Drama' => ['label'=>$this->translate('Drama')],
                    'Science Fiction' => ['label'=>$this->translate('Science Fiction')],
                ],
            ],
            'Government' => [
                'label' =>  $this->translate('Government'),
            ],
            'History' => [
                'label' =>  $this->translate('History'),
            ],
            'Health &amp; Fitness' => [
                'label' =>  $this->translate('Health & Fitness'),
                'children'  =>  [
                    'Alternative Health' => ['label' => $this->translate('Alternative Health')],
                    'Fitness' => ['label' => $this->translate('Fitness')],
                    'Medicine' => ['label' => $this->translate('Medicine')],
                    'Mental Health' => ['label' => $this->translate('Mental Health')],
                    'Nutrition' => ['label' => $this->translate('Nutrition')],
                    'Sexuality' => ['label' => $this->translate('Sexuality')],
                ],
            ],
            'Kids &amp; Family' => [
                'label' =>  $this->translate('Kids & Family'),
                'children'  =>  [
                    'Education for Kids' => ['label' => $this->translate('Education for Kids')],
                    'Parenting' => ['label' => $this->translate('Parenting')],
                    'Pets &amp; Animals' => ['label' => $this->translate('Pets & Animals')],
                    'Stories for Kids' => ['label' => $this->translate('Stories for Kids')],
                ],
            ],
            'Leisure' => [
                'label' =>  $this->translate('Leisure'),
                'children'  =>  [
                    'Animation &amp; Manga' => ['label' => $this->translate('Animation &amp; Manga')],
                    'Automotive' => ['label' => $this->translate('Automotive')],
                    'Aviation' => ['label' => $this->translate('Aviation')],
                    'Crafts' => ['label' => $this->translate('Crafts')],
                    'Games' => ['label' => $this->translate('Games')],
                    'Hobbies' => ['label' => $this->translate('Hobbies')],
                    'Home &amp; Garden' => ['label' => $this->translate('Home & Garden')],
                    'Video Games' => ['label' => $this->translate('Video Games')],
                ],
            ],
            'Music' => [
                'label' =>  $this->translate('Music'),
                'children' => [
                    'Music Commentary' => ['label'=>$this->translate('Music Commentary')],
                    'Music History' => ['label'=>$this->translate('Music History')],
                    'Music Interviews' => ['label'=>$this->translate('Music Interviews')],
                ]
            ],
            'News' => [
                'label' =>  $this->translate('News'),
                'children' => [
                    'Business News' => ['label'=>$this->translate('Business News')],
                    'Daily News' => ['label'=>$this->translate('Daily News')],
                    'Entertainment News' => ['label'=>$this->translate('Entertainment News')],
                    'News Commentary' => ['label'=>$this->translate('News Commentary')],
                    'Politics' => ['label'=>$this->translate('Politics')],
                    'Sports News' => ['label'=>$this->translate('Sports News')],
                    'Tech News' => ['label'=>$this->translate('Tech News')],
                ]
            ],
            'Religion &amp;Spirituality' => [
                'label' =>  $this->translate('Religion & Spirituality'),
                'children'  =>  [
                    'Buddhism' => ['label' => $this->translate('Buddhism')],
                    'Christianity' => ['label' => $this->translate('Christianity')],
                    'Hinduism' => ['label' => $this->translate('Hinduism')],
                    'Islam' => ['label' => $this->translate('Islam')],
                    'Judaism' => ['label' => $this->translate('Judaism')],
                    'Religion' => ['label' => $this->translate('Religion')],
                    'Spirituality' => ['label' => $this->translate('Spirituality')],
                ],
            ],
            'Science' => [
                'label' =>  $this->translate('Science'),
                'children'  =>  [
                    'Astronomy' => ['label' => $this->translate('Astronomy')],
                    'Chemistry' => ['label' => $this->translate('Chemistry')],
                    'Earth Sciences' => ['label' => $this->translate('Earth Sciences')],
                    'Life Sciences' => ['label' => $this->translate('Life Sciences')],
                    'Mathematics' => ['label' => $this->translate('Mathematics')],
                    'Natural Sciences' => ['label' => $this->translate('Natural Sciences')],
                    'Nature' => ['label' => $this->translate('Nature')],
                    'Physics' => ['label' => $this->translate('Physics')],
                    'Social Sciences' => ['label' => $this->translate('Social Sciences')],
                ],
            ],
            'Society &amp; Culture' => [
                'label' =>  $this->translate('Society & Culture'),
                'children'  =>  [
                    'Documentary' => ['label' => $this->translate('Documentary')],
                    'Personal Journals' => ['label' => $this->translate('Personal Journals')],
                    'Philosophy' => ['label' => $this->translate('Philosophy')],
                    'Places &amp; Travel' => ['label' => $this->translate('Places & Travel')],
                    'Relationships' => ['label' => $this->translate('Relationships')],
                ],
            ],
            'Sports' => [
                'label' =>  $this->translate('Sports'),
                'children'  =>  [
                    'Baseball' => ['label' => $this->translate('Baseball')],
                    'Basketball' => ['label' => $this->translate('Basketball')],
                    'Cricket' => ['label' => $this->translate('Cricket')],
                    'Fantasy Sports' => ['label' => $this->translate('Fantasy Sports')],
                    'Football' => ['label' => $this->translate('Football')],
                    'Golf' => ['label' => $this->translate('Golf')],
                    'Hockey' => ['label' => $this->translate('Hockey')],
                    'Rugby' => ['label' => $this->translate('Rugby')],
                    'Running' => ['label' => $this->translate('Running')],
                    'Soccer' => ['label' => $this->translate('Soccer')],
                    'Swimming' => ['label' => $this->translate('Swimming')],
                    'Tennis' => ['label' => $this->translate('Tennis')],
                    'Volleyball' => ['label' => $this->translate('Volleyball')],
                    'Wilderness' => ['label' => $this->translate('Wilderness')],
                    'Wrestling' => ['label' => $this->translate('Wrestling')],
                ],
            ],
            'Technology' => [
                'label' =>  $this->translate('Technology'),
            ],
            'True Crime' => [
                'label' =>  $this->translate('True Crime'),
            ],
            'TV &amp; Film' => [
                'label' =>  $this->translate('TV & Film'),
                'children'  =>  [
                    'After Shows' => ['label' => $this->translate('After Shows')],
                    'Film History' => ['label' => $this->translate('Film History')],
                    'Film Interviews' => ['label' => $this->translate('Film Interviews')],
                    'Film Reviews' => ['label' => $this->translate('Film Reviews')],
                    'TV Reviews' => ['label' => $this->translate('TV Reviews')],
                ],
            ],
        ];
    }

    /**
     * @param string $category
     * @param string|null $subCategory
     * @return mixed
     */
    public function get(string $category, string $subCategory = null)
    {
        if ( ! $subCategory)  {
            return isset($this->all()[$category]) ? $this->all()[$category] : false;
        }
        return isset($this->all()[$category]['children'][$subCategory]) ?
            $this->all()[$category]['children'][$subCategory] : false;
    }

    /**
     * @param string $category
     * @param string|null $subCategory
     * @return mixed
     */
    public function has(string $category, string $subCategory = null)
    {
        return $this->get($category, $subCategory) !== false;
    }

    /**
     * @param string $category
     * @return bool
     */
    public function hasChildren(string $category)
    {
        if ( ! $this->has($category)) {
            return false;
        }
        return isset($this->get($category)['children']) && is_array($this->get($category)['children']) &&
            count($this->get($category)['children']);
    }

    /**
     * Get the children of a category
     *
     * @param string $category
     * @return array
     */
    public function getChildren(string $category)
    {
        if (!$this->hasChildren($category)) {
            return [];
        }
        return $this->get($category)['children'];
    }

    /**
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        return $this->all();
    }

    protected function translate(string $label)
    {
        return $label;
    }
}