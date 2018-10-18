<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FAQsTest extends TestCase
{
    private $admin, $visitor, $noOfFAQs = 5, $delete_id = 100;

    public function setUp()
    {
        parent::setUp();
        TestCase::clenseDB();

        $this->admin = factory(App\User::class)->create([
            'type' => 'admin',
            'user_id' => 1
        ]);

        $this->visitor = factory(App\User::class)->create([
            'type' => 'visitor',
            'user_id' => 2
        ]);

        factory(App\Visitor::class)->create([
            'user_id' => $this->visitor->user_id
        ]);

        for ($i = 1; $i <= $this->noOfFAQs; $i++) {
            factory(App\FAQ::class)->create([
                'question_id' => $i,
                'question' => ('question' . $i),
                'answer' => ('answer' . $i)
            ]);
        }

        factory(App\FAQ::class)->create([
            'question_id' => $this->delete_id,
            'question' => ('question' . $this->delete_id),
            'answer' => ('answer' . $this->delete_id)
        ]);
    }

    public function testEditFAQ()
    {
        $data = array('question' => 'What is the moon made of?', 'answer' => 'Cheese');
        $this->be($this->admin);
        $this->visit('admin/FAQs/edit/' . rand(1, $this->noOfFAQs))
            ->type($data['question'], 'question')
            ->type($data['answer'], 'answer')
            ->press('submit');
        $this->seeInDatabase('faqs', $data);

    }

    public function testCreateFAQ()
    {
        $data = array('question' => 'Where do babies come from?', 'answer' => 'Mr stork delivers them to your house');
        $this->be($this->admin);
        $this->visit('admin/FAQs/create')
            ->type($data['question'], 'question')
            ->type($data['answer'], 'answer')
            ->press('submit');
        $this->seeInDatabase('faqs', $data);

    }

    public function testDeleteFAQ()
    {
        $id = $this->delete_id;
        $data = array('question' => ('question'.$id), 'answer' => ('answer'.$id));
        $this->be($this->admin);
        $this->visit('admin/FAQs/edit/' .$id)
            ->press('delete');
        $this->dontSeeInDatabase('faqs', $data);

    }
    
    public function testAdminEditButton(){
        $id = rand(1, ($this->noOfFAQs-1));
        $this->be($this->admin);
        $this->visit('FAQs')
            ->click('edit-faq-'.$id)
            ->seePageIs('/admin/FAQs/edit/'.$id);
        $this->dontSee('question'.($id+1));
        $this->see('question'.$id);
        
    }
}
