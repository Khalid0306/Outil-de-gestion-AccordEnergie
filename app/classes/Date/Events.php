<?

namespace Date;

use App\Page;

require '../classes/Page.php';

class Events
{
    private \App\Page $page;
    private \PDO $pdo;

    public function __construct(\PDO $pdo, \App\Page $page)
    {
        $this->pdo = $pdo;
        $this->page = $page;
    }

    public function getEvents(\DateTime $start_date, \DateTime $end_date, ?int $id = null, ?string $userRole = null): array
    {
        if ($this->page->Session->asRole('Admin') == $userRole) {
            $sql0 = "SELECT * FROM intervention 
            WHERE date BETWEEN '{$start_date->format('Y-m-d 00:00:00')}' AND '{$end_date->format('Y-m-d 23:59:59')}'
            ORDER BY heure";
            //var_dump($sql);
            $stmt0 = $this->pdo->prepare($sql0);
            $stmt0->execute();
            $result0 = $stmt0->fetchAll(\PDO::FETCH_ASSOC);
            return $result0;

        } elseif ($this->page->Session->asRole('Standardiste') == $userRole) {

            $sql1 = "SELECT * FROM intervention 
            WHERE date BETWEEN '{$start_date->format('Y-m-d 00:00:00')}' AND '{$end_date->format('Y-m-d 23:59:59')}'
            ORDER BY heure";
            //var_dump($sql);
            $stmt1 = $this->pdo->prepare($sql1);
            $stmt1->execute();
            $result1 = $stmt1->fetchAll(\PDO::FETCH_ASSOC);
            return $result1;

        } elseif ($this->page->Session->asRole('Intervenant') == $userRole) {

            $sql2 = "SELECT * FROM intervention
            JOIN intervention_intervenant ON intervention.Id = intervention_intervenant.Id_intervention 
            WHERE date BETWEEN '{$start_date->format('Y-m-d 00:00:00')}' AND '{$end_date->format('Y-m-d 23:59:59')}' AND intervention_intervenant.Id_intervenant = :id
            ORDER BY heure";
            // var_dump($sql2);
            $stmt2 = $this->pdo->prepare($sql2);
            $stmt2->execute([':id' => $id]);
            $results2 = $stmt2->fetchAll(\PDO::FETCH_ASSOC);
            return $results2;

        } elseif ($this->page->Session->asRole('Client')) {

            $sql3 = "SELECT * FROM intervention 
            WHERE date BETWEEN '{$start_date->format('Y-m-d 00:00:00')}' AND '{$end_date->format('Y-m-d 23:59:59')}'
            AND Id_Client = :id
            ORDER BY heure";
            $stmt3 = $this->pdo->prepare($sql3);
            $stmt3->execute(['id' => $id]);
            $results3 = $stmt3->fetchAll(\PDO::FETCH_ASSOC);
            return $results3;

        } else {
            return [];
        }
    }


    public function getEventsById($id): ?array
    {
        $sql = "SELECT * FROM intervention WHERE Id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Vérifier si l'ID existe
        if (!$result) {
            return null;
        }

        return $result;
    }

    public function getEventsDataById($id): ?array
    {
        $sql = "SELECT * FROM intervention 
            LEFT JOIN commentaire ON intervention.Id = commentaire.Id_commentaire
            WHERE intervention.Id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        // Vérifier si l'ID existe
        if (!$result) {
            return null;
        }

        return $result;
    }

    public function getStatusEventById($id): ?array
    {
        $sql = "SELECT DISTINCT * FROM intervention 
            INNER JOIN statusintervention ON intervention.Id_statuts = statusintervention.Id
            WHERE intervention.Id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        // Vérifier si l'ID existe
        if (!$result) {
            return null;
        }

        return $result;
    }


    public function getEventsByDay(\DateTime $start_date, \DateTime $end_date, ?int $id = null, ?string $userRole = null): array
    {   
        if ($this->page->Session->asRole('Standardiste') == $userRole) {
            $events = $this->getEvents($start_date, $end_date,null, $userRole);
        } else {
            $events = $this->getEvents($start_date, $end_date, $id, $userRole);
        }
       
        $days = [];
        foreach ($events as $event) {
            $date = explode(' ', $event['date'])[0];
            if (!isset($days[$date])) {
                $days[$date] = [$event];
            } else {
                $days[$date][] = $event;
            }
        }
        return $days;
    }
}
