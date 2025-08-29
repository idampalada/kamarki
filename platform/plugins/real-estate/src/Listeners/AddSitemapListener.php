<?php

namespace Botble\RealEstate\Listeners;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Location\Repositories\Interfaces\CityInterface;
use Botble\RealEstate\Repositories\Interfaces\AccountInterface;
use Botble\RealEstate\Repositories\Interfaces\CategoryInterface;
use Botble\RealEstate\Repositories\Interfaces\ProjectInterface;
use Botble\RealEstate\Repositories\Interfaces\PropertyInterface;
use Botble\Theme\Events\RenderingSiteMapEvent;
use Botble\RealEstate\Facades\RealEstateHelper;
use Botble\Theme\Facades\SiteMapManager;
use Illuminate\Support\Arr;

class AddSitemapListener
{
    public function __construct(
        protected ProjectInterface $projectRepository,
        protected PropertyInterface $propertyRepository,
        protected AccountInterface $accountRepository,
        protected CategoryInterface $categoryRepository,
        protected CityInterface $cityRepository
    ) {
    }

    public function handle(RenderingSiteMapEvent $event): void
    {
        if ($key = $event->key) {
            switch ($key) {
                case 'agents':

                    $agentLastUpdated = $this->accountRepository
                        ->getModel()
                        ->latest('updated_at')
                        ->value('updated_at');

                    SiteMapManager::add(route('public.agents'), $agentLastUpdated, '0.4', 'monthly');

                    $items = $this->accountRepository
                        ->getModel()
                        ->latest('created_at')
                        ->get();

                    foreach ($items as $item) {
                        SiteMapManager::add($item->url, $item->updated_at, '0.8');
                    }

                    break;

                case 'property-categories':

                    $items = $this->categoryRepository
                        ->getModel()
                        ->with('slugable')
                        ->where('status', BaseStatusEnum::PUBLISHED)
                        ->latest('created_at')
                        ->get();

                    foreach ($items as $item) {
                        SiteMapManager::add($item->url, $item->updated_at, '0.8');
                    }

                    break;

                case 'properties-city':

                    $items = $this->cityRepository
                        ->getModel()
                        ->where('status', BaseStatusEnum::PUBLISHED)
                        ->latest('updated_at')
                        ->get();

                    foreach ($items as $item) {
                        SiteMapManager::add(route('public.properties-by-city', $item->slug), $item->updated_at, '0.8');
                    }

                    break;

                case 'projects-city':

                    $items = $this->cityRepository
                        ->getModel()
                        ->where('status', BaseStatusEnum::PUBLISHED)
                        ->latest('updated_at')
                        ->get();

                    foreach ($items as $item) {
                        SiteMapManager::add(route('public.projects-by-city', $item->slug), $item->updated_at, '0.8');
                    }

                    break;
            }

            if (preg_match('/^properties-((?:19|20|21|22)\d{2})-(0?[1-9]|1[012])$/', $key, $matches)) {
                if (($year = Arr::get($matches, 1)) && ($month = Arr::get($matches, 2))) {
                    $properties = $this->propertyRepository->getModel()
                        ->getModel()
                        ->notExpired()
                        ->where(RealEstateHelper::getPropertyDisplayQueryConditions())
                        ->whereYear('updated_at', $year)
                        ->whereMonth('updated_at', $month)
                        ->latest('updated_at')
                        ->select(['id', 'name', 'updated_at'])
                        ->with(['slugable'])
                        ->get();

                    foreach ($properties as $property) {
                        if (! $property->slugable) {
                            continue;
                        }

                        SiteMapManager::add($property->url, $property->updated_at, '0.8');
                    }
                }
            }

            if (preg_match('/^projects-((?:19|20|21|22)\d{2})-(0?[1-9]|1[012])$/', $key, $matches)) {
                if (($year = Arr::get($matches, 1)) && ($month = Arr::get($matches, 2))) {
                    $projects = $this->projectRepository->getModel()
                        ->getModel()
                        ->where(RealEstateHelper::getProjectDisplayQueryConditions())
                        ->whereYear('updated_at', $year)
                        ->whereMonth('updated_at', $month)
                        ->latest('updated_at')
                        ->select(['id', 'name', 'updated_at'])
                        ->with(['slugable'])
                        ->get();

                    foreach ($projects as $project) {
                        if (! $project->slugable) {
                            continue;
                        }

                        SiteMapManager::add($project->url, $project->updated_at, '0.8');
                    }
                }
            }

            return;
        }

        $properties = $this->propertyRepository->getModel()
            ->selectRaw('YEAR(updated_at) as updated_year, MONTH(updated_at) as updated_month, MAX(updated_at) as updated_at')
            ->notExpired()
            ->where(RealEstateHelper::getPropertyDisplayQueryConditions())
            ->groupBy('updated_year', 'updated_month')
            ->orderBy('updated_year', 'desc')
            ->orderBy('updated_month', 'desc')
            ->get();

        foreach ($properties as $property) {
            $key = sprintf('properties-%s-%s', $property->updated_year, str_pad($property->updated_month, 2, '0', STR_PAD_LEFT));
            SiteMapManager::addSitemap(SiteMapManager::route($key), $property->updated_at);
        }

        $projects = $this->projectRepository->getModel()
            ->selectRaw('YEAR(updated_at) as updated_year, MONTH(updated_at) as updated_month, MAX(updated_at) as updated_at')
            ->where(RealEstateHelper::getProjectDisplayQueryConditions())
            ->groupBy('updated_year', 'updated_month')
            ->orderBy('updated_year', 'desc')
            ->orderBy('updated_month', 'desc')
            ->get();

        foreach ($projects as $project) {
            $key = sprintf('projects-%s-%s', $project->updated_year, str_pad($project->updated_month, 2, '0', STR_PAD_LEFT));
            SiteMapManager::addSitemap(SiteMapManager::route($key), $project->updated_at);
        }

        $agentLastUpdated = $this->accountRepository
            ->getModel()
            ->latest('updated_at')
            ->value('updated_at');

        SiteMapManager::addSitemap(SiteMapManager::route('agents'), $agentLastUpdated);

        $cityLastUpdated = $this->cityRepository
            ->getModel()
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->latest('updated_at')
            ->value('updated_at');

        SiteMapManager::addSitemap(SiteMapManager::route('properties-city'), $cityLastUpdated);
        SiteMapManager::addSitemap(SiteMapManager::route('projects-city'), $cityLastUpdated);
    }
}
