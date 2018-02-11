<?php

use Illuminate\Database\Seeder;
use App\LoanRequest;
use App\User;

class LoanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $admin = User::admin()->first();
        foreach (User::member()->get() as $user) {
            $this->makeSubmittedLoan($user, 10)
                ->makedraftLoan($user, 3)
                ->approveLoan($user, $admin, 5)
                ->rejectLoan($user, $admin, 3)
                ->payLoan($user, 3)
                ->fullyPayLoan($user, 1);
        }
    }

    public function makeSubmittedLoan(User $user, $total)
    {
        $faker = Faker\Factory::create();
        while ($total > 0) {
            $date = $faker->dateTimeThisYear();
            factory(LoanRequest::class)->create([
                'member_id' => $user->id,
                'is_submitted' => true,
                'created_at' => $date
            ]);
            $total--;
        }
        return $this;
    }

    public function makeDraftLoan(User $user, $total)
    {
        $faker = Faker\Factory::create();
        while ($total > 0) {
            $date = $faker->dateTimeThisYear();
            factory(LoanRequest::class)->create([
                'member_id' => $user->id,
                'is_submitted' => false,
                'created_at' => $date
            ]);
            $total--;
        }
        return $this;
    }

    public function approveLoan(User $user, User $admin, $total)
    {
        $data = $user->loanRequests()->waitingApproval()->get()
            ->random($total)
            ->each(function($loanRequest) use ($admin) {
                $loanRequest->update(['is_approved' => true, 'admin_id' => $admin->id]);
            });

        return $this;
    }

    public function rejectLoan(User $user, User $admin, $total)
    {
        $user->loanRequests()->waitingApproval()->get()
            ->random($total)
            ->each(function($loanRequest) use ($admin) {
                $loanRequest->update(['is_approved' => false, 'admin_id' => $admin->id]);
            });
        return $this;
    }

    public function payLoan(User $user, $total)
    {
        return $this;
    }

    public function fullyPayLoan(User $user, $total)
    {
        return $this;
    }
}
