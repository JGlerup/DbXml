<?php 

class Repository
{
    private $connection;
    
    public function __construct(PDO $connection = null)
    {
        $this->connection = $connection;
        if ($this->connection === null) {
            $this->connection = new PDO(
                    'mysql:host=localhost;dbname=dbxml', 
                    'root', 
                    ''
                );
            $this->connection->setAttribute(
                PDO::ATTR_ERRMODE, 
                PDO::ERRMODE_EXCEPTION
            );
        }
    }

    public function find($UserName)
    {
        $stmt = $this->connection->prepare('
            SELECT "User", user.* 
             FROM user 
             WHERE UserName = :UserName
        ');
        $stmt->bindParam(':UserName', $UserName);
        $stmt->execute();
        
        // Set the fetchmode to populate an instance of 'User'
        // This enables us to use the following:
        //     $user = $repository->find(1234);
        //     echo $user->UserName;
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
        return $stmt->fetch();
    }
	
	public function findProgress($id)
    {
        $stmt = $this->connection->prepare('
            SELECT "Progression", progress.* 
             FROM progress 
             WHERE id = :id
        ');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        // Set the fetchmode to populate an instance of 'User'
        // This enables us to use the following:
        //     $user = $repository->find(1234);
        //     echo $user->UserName;
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
        return $stmt->fetch();
    }

    public function findAll()
    {
        $stmt = $this->connection->prepare('
            SELECT * FROM user
        ');
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
        
        // fetchAll() will do the same as above, but we'll have an array. ie:
        //    $user = $repository->findAll();
        //    echo $user[0]->UserName;
        return $stmt->fetchAll();
    }

    public function save($userName,$posX,$posY,$id)
    {
        // If the UserName is set, we're updating an existing record
		$progressExist = $this->findProgress($id);
        if (isset($progressExist['id'])) {
            return $this->update($id,$posX,$posY);
        }
		$P_model = 1;
		$Position = $posX.",".$posY;
        $stmt = $this->connection->prepare('
            INSERT INTO progress 
                (id, P_model, Position) 
            VALUES 
                (:id, :P_model , :Position)
        ');
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':P_model', $P_model);
        $stmt->bindParam(':Position', $Position);
        return $stmt->execute();
    }

    public function update($id,$posX,$posY)
    {
        if (!isset($id)) {
            // We can't update a record unless it exists...
            throw new \LogicException(
                'Cannot update user that does not yet exist in the database.'
            );
        }
		$P_model = 2;
		$Position = $posX.",".$posY;
        $stmt = $this->connection->prepare('
            UPDATE progress
            SET id = :id,
                P_model = :P_model,
                Position = :Position
            WHERE id = :id
        ');
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':P_model', $P_model);
        $stmt->bindParam(':Position', $Position);
        return $stmt->execute();
    }
}