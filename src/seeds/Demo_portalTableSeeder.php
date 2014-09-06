<?php


class Demo_portalTableSeeder extends Seeder
{

    public function run()
    {

        // empty table
        if ($this->command->confirm('Do you wish to empty portals table? [yes|no]')) {
            \DB::table('portals')->truncate();
        }

        $demo_portal = array(
            "id"          => 1,
            "slug"        => "demo",
            "title"       => "Demo Portal",
            "page_id"     => 1,
            "keywords"    => "",
            "description" => "<strong>Welcome to Demo Portal!</strong> You can access frequently asked questions, common forms and templates.",
            "menu_depth"  => 1,
            "status"      => 'published',
            "created_at"  => \Carbon\Carbon::now()->toDateTimeString(),
            "updated_at"  => \Carbon\Carbon::now()->toDateTimeString(),
        );

        // Uncomment the below to run the seeder
        \DB::table('portals')->insert($demo_portal);

        $this->command->info('Portals table seeded!');

        if ($this->command->confirm('Do you wish to empty pages table? [yes|no]')) {
            \DB::table('pages')->truncate();
        }

        $demo_portal = array(
            "id"         => 1,
            "portal_id"  => 1,
            "user_id"    => 1,
            "slug"       => "page",
            "title"      => "Internal Page",
            "excerpt"    => "<p><strong>Internal Portal Page</strong></p>",
            "content"    => "<p><strong>Internal Portal Page!</strong> You can access frequently asked questions, common forms and templates.</p>",
            "type"       => "page",
            "status"     => "published",
            "parent_id"  => 0,
            "menu_order" => 1,
            "created_at" => \Carbon\Carbon::now()->toDateTimeString(),
            "updated_at" => \Carbon\Carbon::now()->toDateTimeString(),
        );

        // Uncomment the below to run the seeder
        \DB::table('pages')->insert($demo_portal);

        $this->command->info('Pages table seeded!');
    }

}
