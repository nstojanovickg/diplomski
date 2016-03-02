<?php namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use App\Models\AdminCredentialQuery;

class AdminCredentialForm extends Form
{
    public function buildForm()
    {
        $credentials = AdminCredentialQuery::create()->find();
        $credentials_arr = array();
        foreach($credentials as $credential){
            $name = $credential->getName();
            $id = $credential->getId();
            $this
                ->add($id, 'choice', [
                    'label' => $name,
                    'choices' => ['read' => 'read', 'write' => 'write', 'exec' => 'exec'],
                    //'selected' => ['read', 'write'],
                    'help_block' => ['credential_tag' => true],
                    'expanded' => true,
                    'multiple' => true
                ]);
        }
    }
}