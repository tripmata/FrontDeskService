<?php


    class Sendmessage_task extends Task
    {
        private $Messageschedule = null;

        function __construct(Subscriber $subscriber, $taskid = null)
        {
            parent::__construct($subscriber, $taskid);
        }

        public function Addmessageschedule(Messageschedule $messageschedule)
        {
            $this->Messageschedule = $messageschedule;
        }

        public function Que()
        {
            parent::Que(); // TODO: Change the autogenerated stub
        }

        public function GetId()
        {
            return parent::GetId(); // TODO: Change the autogenerated stub
        }
    }