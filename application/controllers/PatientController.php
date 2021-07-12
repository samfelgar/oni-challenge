<?php

class PatientController extends Zend_Controller_Action
{
    /**
     * @var Application_Model_PatientMapper
     */
    private $patientMapper;

    public function init()
    {
        $this->patientMapper = new Application_Model_PatientMapper();
    }

    public function indexAction()
    {
        $this->view->patients = $this->patientMapper->fetchAll();
    }

    public function addAction()
    {
        $form = $this->getForm();

        $this->view->form = $form;

        $request = $this->getRequest();

        if ($request->isPost()) {
            $this->save($form);
        }
    }

    public function editAction()
    {
        $form = $this->getForm();

        $this->view->form = $form;

        if ($this->getRequest()->isPost()) {
            $this->save($form);
            return;
        }

        $id = $this->getParam('id');

        if (!$id) {
            return;
        }

        $patient = $this->patientMapper->find($id)->toArray();

        $form->populate($patient);
    }

    private function getForm(): Application_Form_Patient
    {
        $form = new Application_Form_Patient();

        $form->submit->setLabel('Salvar');
        $form->setMethod('post');

        return $form;
    }

    private function save(Application_Form_Patient $form)
    {
        $request = $this->getRequest();

        if (!$form->isValid($request->getPost())) {
            return null;
        }

        $patient = new Application_Model_Patient($form->getValues());

        $this->patientMapper->save($patient);

        return $this->_helper->redirector('index');
    }

    public function deleteAction()
    {
        if (!$this->getRequest()->isPost()) {
            return null;
        }

        $id = $this->getParam('id');

        if (!$id) {
            return null;
        }

        $patient = $this->patientMapper->find($id);

        $this->patientMapper->delete($patient);

        return $this->_helper->redirector('index');
    }
}







