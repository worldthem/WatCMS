<?php

return [
//smallInteger"
//integer
//"string","length"=>10
//"float"
// "text"
 
"author"=>[
     "post_id"=>["type"=>"integer"],
     "title"=>["type"=>"text"],
     "text"=>["type"=>"longtext"],
],

"cart"=>[
     "typecart"=>["type"=>"smallInteger"],
     "user_id"=>["type"=>"string","length"=>40],
     "product_id"=>["type"=>"integer"],
     "qty"=>["type"=>"smallInteger"],
     "downloaded"=>["type"=>"smallInteger"],
     "options_id"=>["type"=>"integer"],
     "price"=>["type"=>"float"],
     "date"=>["type"=>"dateTime"],
     "created_at"=>["type"=>"dateTime"],
     "updated_at"=>["type"=>"dateTime"],
     "orderid"=>["type"=>"integer"],
],

"colectmail"=>[
     "email"=>["type"=>"string","length"=>200],
     "date"=>["type"=>"dateTime"],
     "types"=>["type"=>"string","length"=>20],
],

"comments"=>[
     "id_post"=>["type"=>"integer"],
     "id_user"=>["type"=>"integer"],
     "comment_author"=>["type"=>"string","length"=>300],
     "comment_author_email"=>["type"=>"string","length"=>255],
     "comment_author_IP"=>["type"=>"string","length"=>100],
     "comment"=>["type"=>"text"],
     "status"=>["type"=>"smallInteger"],
     "stars"=>["type"=>"smallInteger"],
     "updated_at"=>["type"=>"dateTime"],
     "created_at"=>["type"=>"dateTime"],
],

"country"=>[
     "country"=>["type"=>"string","length"=>200],
     "code"=>["type"=>"string","length"=>15],
     "store"=>["type"=>"smallInteger"],
     "price"=>["type"=>"float"],
     "shipping"=>["type"=>"string","length"=>200],
     "price1"=>["type"=>"float"],
     "shipping1"=>["type"=>"string","length"=>200],
     "price2"=>["type"=>"float"],
     "shipping2"=>["type"=>"string","length"=>200],
],

"cupon"=>[
     "cupon"=>["type"=>"string","length"=>100],
     "amount"=>["type"=>"float"],
     "type"=>["type"=>"string","length"=>10],
     "used"=>["type"=>"integer"],
     "publish"=>["type"=>"string","length"=>20],
     "created_at"=>["type"=>"dateTime"],
     "updated_at"=>["type"=>"dateTime"],
],

"cupon_applied"=>[
     "cupon_id"=>["type"=>"integer"],
     "user_id"=>["type"=>"string","length"=>40],
     "order_id"=>["type"=>"integer"],
     "updated_at"=>["type"=>"dateTime"],
     "created_at"=>["type"=>"dateTime"],
],

"gallery"=>[
     "sesion_id"=>["type"=>"string","length"=>255],
     "id_post"=>["type"=>"bigInteger"],
     "id_user"=>["type"=>"integer"],
     "directory"=>["type"=>"text"],
     "directory_thumb"=>["type"=>"string","length"=>350],
     "sort"=>["type"=>"smallInteger"],
     "main"=>["type"=>"smallInteger"],
     "import"=>["type"=>"smallInteger"],
],

"categories"=>[
     "type"=>["type"=>"string","length"=>30],
     "post_type"=>["type"=>"string","length"=>30],
     "parent"=>["type"=>"integer"],
     "title"=>["type"=>"text"],
     "metad"=>["type"=>"text"],
     "metak"=>["type"=>"text"],
     "image"=>["type"=>"string","length"=>80],
     "cpu"=>["type"=>"text"],
     "url"=>["type"=>"string","length"=>255],
     "tip"=>["type"=>"smallInteger"],
     "sort"=>["type"=>"smallInteger"],
     "text"=>["type"=>"text"],
     "date"=>["type"=>"string","length"=>20],
     "param"=>["type"=>"smallInteger"],
     "lang"=>["type"=>"string","length"=>20],
],

"orders"=>[
     "user_id"=>["type"=>"integer"],
     "pid"=>["type"=>"integer"],
     "sessionuser"=>["type"=>"string","length"=>70],
     "secretnr"=>["type"=>"string","length"=>100],
     "shipping"=>["type"=>"text"],
     "options"=>["type"=>"text"],
     "status"=>["type"=>"string","length"=>100],
     "message"=>["type"=>"string","length"=>150],
     "updated_at"=>["type"=>"dateTime"],
     "created_at"=>["type"=>"dateTime"],
],

"page"=>[
     "sort"=>["type"=>"integer"],
     "cat"=>["type"=>"string","length"=>150],
     "type"=>["type"=>"string","length"=>20],
     "cpu"=>["type"=>"string","length"=>300],
     "title"=>["type"=>"string","length"=>300],
     "options"=>["type"=>"text"],
     "text"=>["type"=>"text"],
     "main"=>["type"=>"string","length"=>20],
     "updated_at"=>["type"=>"dateTime"],
     "created_at"=>["type"=>"dateTime"], 
],

"product"=>[
     "user_id"=>["type"=>"integer"],
     "cat"=>["type"=>"string","length"=>255],
     "SKU"=>["type"=>"string","length"=>100],
     "qtu"=>["type"=>"integer"],
     "store"=>["type"=>"smallInteger"],
     "title"=>["type"=>"string","length"=>512],
     "cpu"=>["type"=>"string","length"=>512],
     "meta"=>["type"=>"text"],
     "description"=>["type"=>"text"],
     "text"=>["type"=>"text"],
     "weight"=>["type"=>"float"],
     "price"=>["type"=>"float"],
     "sale_price"=>["type"=>"float"],
     "attr"=>["type"=>"json"],
     "optionsdata"=>["type"=>"text"],
     "hide"=>["type"=>"smallInteger"],
     "updated_at"=>["type"=>"dateTime"],
     "created_at"=>["type"=>"dateTime"],
],

"role"=>[
     "role_name"=>["type"=>"string","length"=>255],
     "role_description"=>["type"=>"text"],
     "created_at"=>["type"=>"dateTime"],
     "updated_at"=>["type"=>"dateTime"],
],

"sessions"=>[
     "user_id"=>["type"=>"integer"],
     "ip_address"=>["type"=>"string","length"=>45],
     "user_agent"=>["type"=>"text"],
     "payload"=>["type"=>"text"],
     "last_activity"=>["type"=>"integer"],
],

"settings"=>[
     "param"=>["type"=>"string","length"=>150],
     "value"=>["type"=>"string","length"=>255],
     "value1"=>["type"=>"longtext"],
     "value2"=>["type"=>"string","length"=>255],
     "autoload"=>["type"=>"string","length"=>3],
],

"meta"=>[
     "param"=>["type"=>"string","length"=>150],
     "value"=>["type"=>"string","length"=>255],
     "value2"=>["type"=>"string","length"=>255],
     "text"=>["type"=>"text"],
     "created_at"=>["type"=>"dateTime"],
     "updated_at"=>["type"=>"dateTime"],
],

"shiping"=>[
     "type_shipping"=>["type"=>"integer"],
     "shipping_name"=>["type"=>"string","length"=>255],
     "store"=>["type"=>"smallInteger"],
     "country"=>["type"=>"integer"],
     "weight"=>["type"=>"float"],
     "price"=>["type"=>"float"],
     "free_delivery"=>["type"=>"float"],
     "hide_show"=>["type"=>"integer"],
     "showhide"=>["type"=>"smallInteger"],
],

"shippcountry"=>[
     "country"=>["type"=>"string","length"=>200],
     "code"=>["type"=>"string","length"=>15],
     "store"=>["type"=>"smallInteger"],
     "price"=>["type"=>"float"],
     "shipping"=>["type"=>"string","length"=>200],
     "price1"=>["type"=>"float"],
     "shipping1"=>["type"=>"string","length"=>200],
     "price2"=>["type"=>"float"],
     "shipping2"=>["type"=>"string","length"=>200],
],

"uploads"=>[
     "type"=>["type"=>"string","length"=>20],
     "id_post"=>["type"=>"integer"],
     "file_title"=>["type"=>"string","length"=>255],
     "file"=>["type"=>"string","length"=>200],
     "originalFileName"=>["type"=>"string","length"=>255],
     "date"=>["type"=>"dateTime"],
],

"usermeta"=>[
     "user_id"=>["type"=>"integer"],
     "meta_key"=>["type"=>"string","length"=>255],
     "meta_value"=>["type"=>"longtext"],
],

"users"=>[
     "name"=>["type"=>"string","length"=>255],
     "email"=>["type"=>"string","length"=>255],
     "user_role"=>["type"=>"smallInteger"],
     "password"=>["type"=>"string","length"=>255],
     "remember_token"=>["type"=>"string","length"=>100],
     "created_at"=>["type"=>"dateTime"],
     "updated_at"=>["type"=>"dateTime"],
     "status"=>["type"=>"dateTime"],
],

"visits"=>[
     "pagevisit"=>["type"=>"longtext"],
     "ipvisit"=>["type"=>"string","length"=>20],
     "date"=>["type"=>"dateTime"],
     "url"=>["type"=>"string","length"=>300],
     "user_agent"=>["type"=>"string","length"=>300],
     "browser_language"=>["type"=>"string","length"=>20],
     "updated_at"=>["type"=>"dateTime"],
     "created_at"=>["type"=>"dateTime"],
],

"wishlist"=>[
     "session"=>["type"=>"string","length"=>50],
     "idproduct"=>["type"=>"integer"],
     "types"=>["type"=>"string","length"=>50],
],

];

 