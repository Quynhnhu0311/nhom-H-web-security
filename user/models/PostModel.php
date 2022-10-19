<?php


require_once 'BaseModel.php';

class PostModel extends BaseModel
{
    public function findPostById($post_id)
    {
        $sql = 'SELECT * FROM post WHERE post_id = ' . $post_id;
        $post = $this->select($sql);

        return $post;
    }
    /**
     * Delete user by id
     * @param $id
     * @return mixed
     */
    public function deletePostById($post_id, $token)
    {
        $sql = " DELETE FROM post WHERE post_id = '$post_id' AND token = '$token'";
        return $this->delete($sql);
    }
    /**
     * Insert post
     * @param $input
     * @return mixed
     */
    public function insertPost($input)
    {
        $sql = "INSERT INTO `post`(`post_url`, `post_title`, `post_description`, `token`) 
        VALUES (" .
            "'" . $input['post_url'] . "',
                '" . $input['post_title'] . "',
                '" . $input['post_description'] . "',
                 '" . $input['token'] . "')";

        $post = $this->insert($sql);

        return $post;
    }

    /**
     * Search users
     * @param array $params
     * @return array
     */
    public function getPosts($params = [])
    {
        //Keyword
        if (!empty($params['keyword'])) {
            $sql = 'SELECT * FROM post WHERE name LIKE "%' . $params['keyword'] . '%"';

            //Keep this line to use Sql Injection
            //Don't change
            //Example keyword: abcef%";TRUNCATE banks;##
            $post = self::$_connection->multi_query($sql);
        } else {
            $sql = 'SELECT * FROM post';
            $post = $this->select($sql);
        }

        return $post;
    }
}
