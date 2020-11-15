
--We want to select the posts that have the text 'a'

SELECT * FROM posts
WHERE title LIKE '%a%'
UNION
SELECT * FROM posts
WHERE id IN (
    SELECT postId
    FROM htmlelements 
    WHERE content LIKE '%a%' 
    GROUP BY postId
)

SELECT * FROM (
    SELECT * FROM posts WHERE title LIKE '%a%'
    UNION
    SELECT * FROM posts WHERE id IN (
        SELECT postId   
        FROM htmlelements
        WHERE content LIKE '%a%'
        GROUP BY postId
    )
) AS foundPosts WHERE STATUS = 'published';




SELECT postId 
FROM htmlelements 
WHERE content LIKE '%a%' 
GROUP BY postId;

4,5,11,18,20,25