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

    public function save($userName,$posX,$posY)
    {
        // If the UserName is set, we're updating an existing record
        //if (isset($user->username)) {
        //    return $this->update($user);
        //}
		$user = find($userName);

        $stmt = $this->connection->prepare('
            INSERT INTO progress 
                (id, P_model, Position) 
            VALUES 
                (:id, :P_model , :Position)
        ');
        $stmt->bindParam(':id', $user->Progression);
        $stmt->bindParam(':P_model', "Yatta");
        $stmt->bindParam(':Position', $posX.",".$posY);
        return $stmt->execute();
    }

    public function update($user)
    {
        if (!isset($user->UserName)) {
            // We can't update a record unless it exists...
            throw new \LogicException(
                'Cannot update user that does not yet exist in the database.'
            );
        }
        $stmt = $this->connection->prepare('
            UPDATE user
            SET UserName = :UserName,
                Password = :Password,
                Progression = :Progression,
                Facebook = :Facebook
            WHERE UserName = :UserName
        ');
        $stmt->bindParam(':UserName', $user->UserName);
        $stmt->bindParam(':Password', $user->Password);
        $stmt->bindParam(':Progression', $user->Progression);
        $stmt->bindParam(':Facebook', $user->Facebook);
        return $stmt->execute();
    }
}