<?php 
    namespace App\Models;

    use CodeIgniter\Model; 

    class EpargneModel extends Model{
        protected $table = 'epargne';
        protected $primaryKey = 'id';
        protected $returnType = ['id_client ', 'pourcentage', 'solde'];

        public function getParClient(int $clientId){
            return $this->where('id_client', $clientId)->frist();
        }

        public function mettreAJourSolde(int $clientId, float $nouveauSolde){
            $this->where('id_client', $clientId)->set(['solde'=> $nouveauSolde])->update();
        }
        public function mettreAJourTaux(int $clientId, float $pourcentage){
            $this->where('id_client', $clientId)->set(['pourcentage'=> $pourcentage])->update();
        }

    }