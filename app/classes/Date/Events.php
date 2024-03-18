<?
namespace Date;

use App\Page;

require '../classes/Page.php';

class Events {

    private \PDO $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getEvents(\DateTime $start_date, \DateTime $end_date) : array {
        $sql = "SELECT * FROM intervention 
        WHERE date BETWEEN '{$start_date->format('Y-m-d 00:00:00')}' AND '{$end_date->format('Y-m-d 23:59:59')}'
        ORDER BY heure";
        // var_dump($sql);
        $stmt = $this->pdo->query($sql);
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $results;
    }

    public function getEventsById($id) : array {
        $sql = "SELECT * FROM intervention WHERE Id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $results;
    }

    public function getEventsDataById($id) : array {
        $sql = "SELECT * FROM intervention WHERE Id = :id
                FULL JOIN commentaire ON  intervention.Id = commentaire.Id_intervention";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $results;
    }

    public function getEventsByDay(\DateTime $start_date, \DateTime $end_date) : array {
        $events = $this->getEvents($start_date, $end_date);
        $days = [];
        foreach($events as $event){
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
