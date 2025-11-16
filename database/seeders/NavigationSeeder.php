<?php
namespace Database\Seeders;

use App\Models\Navigation;
use Illuminate\Database\Seeder;

class NavigationSeeder extends Seeder
{
    public function run(): void
    {
        $navigations = [
            ['label' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'home', 'order' => 0, 'status' => 1],
            ['label' => 'Posts', 'route' => 'posts.index', 'icon' => 'file-text', 'order' => 1, 'status' => 1],
            ['label' => 'Products', 'route' => 'products.index', 'icon' => 'package', 'order' => 2, 'status' => 1],
            ['label' => 'About', 'route' => 'abouts.index', 'icon' => 'info', 'order' => 3, 'status' => 1],
            ['label' => 'Services', 'route' => 'services.index', 'icon' => 'briefcase', 'order' => 4, 'status' => 1],
            ['label' => 'Why Choose Us', 'route' => 'whychooseus.index', 'icon' => 'help-circle', 'order' => 5, 'status' => 1],
            ['label' => 'Agenda', 'route' => 'agendas.index', 'icon' => 'calendar', 'order' => 6, 'status' => 1],
            ['label' => 'Our Values', 'route' => 'ourvalues.index', 'icon' => 'star', 'order' => 7, 'status' => 1],
            ['label' => 'Our Clients', 'route' => 'ourclient.index', 'icon' => 'users', 'order' => 8, 'status' => 1],
            ['label' => 'Testimonials', 'route' => 'testimonials.index', 'icon' => 'message-square', 'order' => 9, 'status' => 1],
            ['label' => 'Our Team', 'route' => 'teams.index', 'icon' => 'users-2', 'order' => 10, 'status' => 1],
            ['label' => 'Contact Messages', 'route' => 'contacts.index', 'icon' => 'mail', 'order' => 11, 'status' => 1],
        ];

        foreach ($navigations as $nav) {
            Navigation::updateOrCreate(
                ['route' => $nav['route']],
                $nav
            );
        }
    }
}
