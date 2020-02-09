<?php

use Illuminate\Database\Seeder;

class VotablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('votables')->delete();

        $users = \App\User::all();
        $numberOfUser = $users->count();
        $votes = [-1, 1];

        foreach (\App\Question::all() as $question) {
            for ($i = 0; $i < rand(1, $numberOfUser); $i++) {
                $user = $users[$i];
                $user->voteQuestion($question, $votes[rand(0, 1)]);
            }
        }

        foreach (\App\Answer::all() as $answer) {
            for ($i = 0; $i < rand(1, $numberOfUser); $i++) {
                $user = $users[$i];
                $user->voteAnswer($answer, $votes[rand(0, 1)]);
            }
        }
    }
}
