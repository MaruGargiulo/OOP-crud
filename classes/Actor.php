<?php 

    class Actor 
    {
        private $id;
        private $first_name;
        private $last_name;
        private $rating;
        private $favorite_movie_id;

        // ¿porqué no pongo el id de la película favorita en el constructor? porque de esa forma estoy obligando a que SÍ O SÍ ese actor tenga que tener una película favorita para poder instanciarse, y no es un dato ESCENCIAL. Pero sí es un dato que más adelante voy a querer setear, por lo tanto tendrá su setter y getter
        public function __construct($first_name, $last_name, $rating)
        {
            $this->first_name = $first_name;
            $this->last_name = $last_name;
            $this->rating = $rating;
        }


        public function getId()
        {
            return $this->id;
        }

        public function setId($id)
        {
            $this->id = $id;
        }

        public function getFirstName()
        {
            return $this->first_name;
        }

        public function setFirstName($first_name)
        {
            $this->first_name = $first_name;
        }

        public function getLastName()
        {
            return $this->last_name;
        }

        public function setLasName($last_name)
        {
            $this->last_name = $last_name;
        }

        public function getRating()
        {
            return $this->rating;
        }

        public function setRating($rating)
        {
            $this->rating = $rating;
        }

        public function getFavoriteMovieId()
        {
            if($this->favorite_movie_id)
            {
                return $this->favorite_movie_id;
            }
            return 'Sin película favorita';
        }

        public function setFavoriteMovieId($favorite_movie_id)
        {
            $this->favorite_movie_id = $favorite_movie_id;
        }

    }   

?>