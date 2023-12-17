<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->bind(
           'App\Interfaces\Section\SectionRepositoryInterface',
           'App\Repositories\Section\SectionRepository',
        );

        $this->app->bind(
            'App\Interfaces\Doctor\DoctorRepositoryInterface',
            'App\Repositories\Doctor\DoctorRepository',
        );

        $this->app->bind(
            'App\Interfaces\Services\SingleServiceRepositoryInterface',
            'App\Repositories\Services\SingleServiceRepository',
        );

        $this->app->bind(
            'App\Interfaces\Insurances\InsuranceRepositoryInterface',
            'App\Repositories\Insurances\InsuranceRepository',
        );

        $this->app->bind(
            'App\Interfaces\Patient\PatientRepositoryInterface',
            'App\Repositories\Patient\PatientRepository',
        );
    }

       public function boot(): void
    {
        //
    }
}
