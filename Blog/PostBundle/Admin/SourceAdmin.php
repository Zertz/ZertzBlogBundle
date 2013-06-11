<?php
namespace Zertz\Blog\PostBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Validator\ErrorElement;

class SourceAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name')
            ->add('link')
        ;
    }
    
    protected function configureRoutes(RouteCollection $collection)
    {
        parent::configureRoutes($collection);
        
        if($this->hasParentFieldDescription()) {
            $collection->remove('delete');
        }
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('link')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('link')
        ;
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        $errorElement
            ->end()
        ;
    }
}
