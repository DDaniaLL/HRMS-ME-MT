<?php

namespace App\Providers;

use App\Models\Leave;
use App\Models\Overtime;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        if (config('app.env') === 'production') {
            \URL::forceScheme('https');
        }


        view()->composer('*', function ($view) {

            if ($view->getName() != 'auth.login') {
                if (Auth::check()) {

                    $user = Auth::user();
                    $staff = User::where('linemanager', $user->name)->get();

                    if (count($staff)) {
                        $subsets = $staff->map(function ($staff) {
                            return collect($staff->toArray())
                                ->only(['id'])
                                ->all();
                        });

                        $leaves = Leave::whereIn('user_id', $subsets)
                            ->where('status', 'Pending LM Approval')
                            ->orwhere(function ($query) use ($user) {
                                $query->where('status', 'Pending extra Approval')
                                    ->where('exapprover', $user->name);
                            })
                            ->get();
                        $overtimes = Overtime::whereIn('user_id', $subsets)
                            ->where('status', 'Pending LM Approval')
                            ->orwhere(function ($query) use ($user) {
                                $query->where('status', 'Pending extra Approval')
                                    ->where('exapprover', $user->name);
                            })
                            ->get();

                        $numleaveapproval = count($leaves);

                        $numoverapproval = count($overtimes);
                        $numapproval = $numleaveapproval + $numoverapproval;

                        if ($user->office == 'CO-Erbil') {
                            $hrleaves = Leave::where('status', 'Pending HR Approval')->orWhere('status', 'Approved by extra Approval')->orWhere('status', 'Declined by extra Approval')->get();
                            $hrovertimes = Overtime::where('status', 'Pending HR Approval')->orWhere('status', 'Approved by extra Approval')->orWhere('status', 'Declined by extra Approval')->get();
                            $numleavehrapproval = count($hrleaves);
                            $numoverhrapproval = count($hrovertimes);
                            $numhrapproval = $numleavehrapproval + $numoverhrapproval;

                            $view->with('numleaveapproval', $numleaveapproval)
                                ->with('numoverapproval', $numoverapproval)
                                ->with('numapproval', $numapproval)
                                ->with('numleavehrapproval', $numleavehrapproval)
                                ->with('numoverhrapproval', $numoverhrapproval)
                                ->with('numhrapproval', $numhrapproval);
                        } else { // if i am LM but not CO-Erbil HR
                            $staffwithsameoffice = User::where('office', $user->office)->get();
                            if (count($staffwithsameoffice)) {
                                $hrsubsets = $staffwithsameoffice->map(function ($staffwithsameoffice) {
                                    return collect($staffwithsameoffice->toArray())
                                        ->only(['id'])
                                        ->all();
                                });
                                $hrleaves = Leave::whereIn('user_id', $hrsubsets)->where(function ($query) {
                                    $query->where('status', 'Pending HR Approval')
                                        ->orwhere('status', 'Approved by extra Approval')->orwhere('status', 'Declined by extra Approval');
                                })->get();
                                $hrovertimes = Overtime::whereIn('user_id', $hrsubsets)->where(function ($query) {
                                    $query->where('status', 'Pending HR Approval')
                                        ->orwhere('status', 'Approved by extra Approval')->orwhere('status', 'Declined by extra Approval');
                                })->get();
                                $numleavehrapproval = count($hrleaves);
                                $numoverhrapproval = count($hrovertimes);
                                $numhrapproval = $numleavehrapproval + $numoverhrapproval;

                                $view->with('numleaveapproval', $numleaveapproval)
                                    ->with('numoverapproval', $numoverapproval)
                                    ->with('numapproval', $numapproval)
                                    ->with('numleavehrapproval', $numleavehrapproval)
                                    ->with('numoverhrapproval', $numoverhrapproval)
                                    ->with('numhrapproval', $numhrapproval);
                            } else { // if no staff with me in the same office
                                $view->with('numleaveapproval', '0')
                                    ->with('numoverapproval', '0')
                                    ->with('numapproval', '0')
                                    ->with('numleavehrapproval', '0')
                                    ->with('numoverhrapproval', '0')
                                    ->with('numhrapproval', '0');
                            }

                        }

                    } else {
                        // if i am not LM but still HR:

                        if ($user->office == 'CO-Erbil') {
                            // if i am CO-Erbil HR
                            $hrleaves = Leave::where('status', 'Pending HR Approval')->orWhere('status', 'Approved by extra Approval')->orWhere('status', 'Declined by extra Approval')->get();
                            $hrovertimes = Overtime::where('status', 'Pending HR Approval')->orWhere('status', 'Approved by extra Approval')->orWhere('status', 'Declined by extra Approval')->get();
                            $numleavehrapproval = count($hrleaves);
                            $numoverhrapproval = count($hrovertimes);
                            $numhrapproval = $numleavehrapproval + $numoverhrapproval;
                            $view->with('numleaveapproval', '0')
                                ->with('numoverapproval', '0')
                                ->with('numapproval', '0')
                                ->with('numleavehrapproval', $numleavehrapproval)
                                ->with('numoverhrapproval', $numoverhrapproval)
                                ->with('numhrapproval', $numhrapproval);
                        } else { // i am not LM and HR but not CO-Erbil HR
                            $staffwithsameoffice = User::where('office', $user->office)->get();
                            if (count($staffwithsameoffice)) {
                                $hrsubsets = $staffwithsameoffice->map(function ($staffwithsameoffice) {
                                    return collect($staffwithsameoffice->toArray())
                                        ->only(['id'])
                                        ->all();
                                });
                                $hrleaves = Leave::whereIn('user_id', $hrsubsets)->where(function ($query) {
                                    $query->where('status', 'Pending HR Approval')
                                        ->orwhere('status', 'Approved by extra Approval')->orwhere('status', 'Declined by extra Approval');
                                })->get();
                                $hrovertimes = Overtime::whereIn('user_id', $hrsubsets)->where(function ($query) {
                                    $query->where('status', 'Pending HR Approval')
                                        ->orwhere('status', 'Approved by extra Approval')->orwhere('status', 'Declined by extra Approval');
                                })->get();
                                $numleavehrapproval = count($hrleaves);
                                $numoverhrapproval = count($hrovertimes);
                                $numhrapproval = $numleavehrapproval + $numoverhrapproval;

                                $view->with('numleaveapproval', '0')
                                    ->with('numoverapproval', '0')
                                    ->with('numapproval', '0')
                                    ->with('numleavehrapproval', $numleavehrapproval)
                                    ->with('numoverhrapproval', $numoverhrapproval)
                                    ->with('numhrapproval', $numhrapproval);
                            } else { // if no staff with me in the same office
                                $view->with('numleaveapproval', '0')
                                    ->with('numoverapproval', '0')
                                    ->with('numapproval', '0')
                                    ->with('numleavehrapproval', '0')
                                    ->with('numoverhrapproval', '0')
                                    ->with('numhrapproval', '0');
                            }

                        }

                    }
                    // if i am not LM and not HR no need to handle it becuse in the app layout it's not processed
                }
            }

        }
        );
    }
}
