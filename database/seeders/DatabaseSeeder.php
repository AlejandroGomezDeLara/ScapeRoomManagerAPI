<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\GameCategory;
use App\Models\GameSubcategory;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'Admin',
            'display_name' => 'Administrador',
        ]);

        Role::create([
            'name' => 'Client',
            'display_name' => 'Usuario normal',
        ]);

        Role::create([
            'name' => 'Enterprise',
            'display_name' => 'Empresa',
        ]);

        Role::create([
            'name' => 'Employee',
            'display_name' => 'Trabajador',
        ]);

        User::create([
            'name' => 'Yamishibai',
            'email' => 'yami@scape.es',
            'password' => '$2a$10$xgQbXMEC1rpX6PxKYzbOXOD6ADpLncYx9m5ZxS72VVbkBU/wclOLu',
            'role_id' => 1,
            'avatar' => 'https://www.pngall.com/wp-content/uploads/12/Avatar-Profile-Vector-PNG-File.png'
        ]);

        User::create([
            'name' => 'Cliente',
            'email' => 'cliente@scape.es',
            'password' => '$2a$10$xgQbXMEC1rpX6PxKYzbOXOD6ADpLncYx9m5ZxS72VVbkBU/wclOLu',
            'role_id' => 2,
            'avatar' => 'https://www.pngall.com/wp-content/uploads/12/Avatar-Profile-Vector-PNG-File.png'
        ]);

        User::create([
            'name' => 'Daddoo',
            'email' => 'daddoo@scape.es',
            'password' => '$2a$10$xgQbXMEC1rpX6PxKYzbOXOD6ADpLncYx9m5ZxS72VVbkBU/wclOLu',
            'role_id' => 3,
            'avatar' => 'https://www.pngall.com/wp-content/uploads/12/Avatar-Profile-Vector-PNG-File.png'
        ]);

        User::create([
            'name' => 'LaserMax',
            'email' => 'lasermax@scape.es',
            'password' => '$2a$10$xgQbXMEC1rpX6PxKYzbOXOD6ADpLncYx9m5ZxS72VVbkBU/wclOLu',
            'role_id' => 3,
            'avatar' => 'https://www.pngall.com/wp-content/uploads/12/Avatar-Profile-Vector-PNG-File.png'
        ]);

        User::create([
            'name' => 'Empleado',
            'email' => 'empleado@scape.es',
            'password' => '$2a$10$xgQbXMEC1rpX6PxKYzbOXOD6ADpLncYx9m5ZxS72VVbkBU/wclOLu',
            'role_id' => 4,
            'avatar' => 'https://www.pngall.com/wp-content/uploads/12/Avatar-Profile-Vector-PNG-File.png'
        ]);

        GameCategory::create([
            'name' => 'Scape Room',
            'color' => '#6b1b91',
            'background_color' => '#e8c1fa'
        ]);
        GameCategory::create([
            'name' => 'Laser Tag',
            'color' => '#2a26ac',
            'background_color' => '#adabf7'
        ]);
        GameCategory::create([
            'name' => 'Carts',
            'color' => '#234f0f',
            'background_color' => '#c4f5ae'
        ]);

        GameSubcategory::create([
            'name' => 'Miedo',
            'color' => '#343a40',
            'background_color' => '#cfd2d2',
            'category_id' => 1
        ]);

        GameSubcategory::create([
            'name' => 'Interior',
            'color' => '#343a40',
            'category_id' => 3,
            'background_color' => '#cfd2d2'
        ]);

        Game::create([
            'name' => 'Los Invitados',
            'rating' => 2.3,
            'reviews_count' => 123,
            'user_id' => 3,
            'address' => 'C. Medina del Campo, 11520 Rota, C??diz',
            'city' => 'Rota',
            'postal_code' => '11520',
            'description' => 'Este es el mejor Scape que existe porque es de miedo jaja',
            'image' => 'https://cdn.escapistas.club/images/daddoo-escape-room/los-invitados/Invitados.jpg-escapistasclubresized/w400.jpg',
            'min_people' => 2,
            'max_people' => 6,
            'min_duration' => 20,
            'max_duration' => 60,
            'min_price' => 12,
            'category_id' => 1,
            'subcategory_id' => 1,
            'difficulty'=>8
        ]);

        Game::create([
            'name' => 'Laser Space',
            'rating' => 3,
            'reviews_count' => 23,
            'user_id' => 4.85,
            'address' => 'Plaza Emperador Carlos V,  n?? 8 (junto al Simply), Madrid',
            'city' => 'Madrid',
            'postal_code' => '11405',
            'description' => 'Este es el mejor Laser Tag que existe porque es de miedo jaja',
            'image' => 'assets/imgs/laser-tag.jpeg',
            'min_people' => 5,
            'max_people' => 20,
            'min_duration' => 30,
            'max_duration' => 120,
            'min_price' => 21,
            'category_id' => 2,
            'difficulty'=>6
        ]);

        Game::create([
            'name' => 'Karts Luz Shopping',
            'rating' => 4.2,
            'reviews_count' => 13,
            'user_id' => 4,
            'address' => 'Rda. Aurora Boreal, s/n, Local 31, 11407 Jerez de la Frontera, C??diz',
            'city' => 'Jerez',
            'postal_code' => '11401',
            'description' => 'Dos circuitos, indoor y outdoor, para disfrutar al m??ximo del placer de pilotar un kart. Opciones para todas las edades y m??s actividades como Escape Room y nuestro Simulador F1 que te har??n vivir una experiencia que no podr??s olvidar f??cilmente.',
            'image' => 'https://racingdakartjerez.es/wp-content/uploads/circuito_indoor_actual.jpg',
            'min_people' => 12,
            'max_people' => 30,
            'min_duration' => 60,
            'max_duration' => 180,
            'min_price' => 35,
            'category_id' => 3,
            'difficulty'=>9
        ]);
    }
}
