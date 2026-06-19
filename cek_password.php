<?php

$hash = '$2y$10$Q9GQ3Gm0s5J5x9P8u6mQ5e9f4zPz7i2i9h4n8k2z0y1p5r6t7u8v2';

if(password_verify('12345', $hash)){
    echo "Password cocok";
}else{
    echo "Password tidak cocok";
}