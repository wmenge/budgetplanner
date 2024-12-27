-- ----------------------------
--  View structure for "categories_tree"
-- ----------------------------
DROP VIEW IF EXISTS "categories_tree";
CREATE VIEW IF NOT EXISTS categories_tree
AS 
WITH RECURSIVE
  categories_cte(id,parent_id,description,root,level, breadcrump, path, breadcrumpobject) AS (
    SELECT id,parent_id,description,id,0,description, "'" || id || "'", "{ ""id"": " || id || ", ""description"": """ || description || """ }"
        FROM categories
        WHERE parent_id is null
    UNION ALL
        SELECT x.id,x.parent_id,x.description,y.root,y.level+1,y.breadcrump || ' / ' || x.description, y.path || ", '" || x.id || "'",
            y.breadcrumpobject || ", { ""id"": " || x.id || ", ""description"": """ || x.description || """}"
            FROM categories AS x
            INNER JOIN categories_cte AS y ON (x.parent_id=y.id)
  )
SELECT id,parent_id,description,root,level,breadcrump, "[" || path  || "]" as path, "[" || breadcrumpobject  || "]" as breadcrumpobject
    FROM categories_cte
    order by breadcrump;

