<?php
declare(strict_types=1);

namespace App\Collection\Model;

trait CountryCodeTrait
{
    protected array $countries = [];

    public function addCountryCode(string $countryCode): void
    {
        $this->countries[] = $countryCode;
    }

    public function getCountryCodes(): array
    {
        return $this->countries;
    }

    public function hasLimitedCountryCodes(): bool
    {
        return !in_array('WW', $this->countries, true);
    }

    public function isBlockedForCountry(string $countryCode): bool
    {
        if(!$this->hasLimitedCountryCodes()){
            return false;
        }
        return !in_array(strtoupper($countryCode), $this->countries, true);
    }
}
