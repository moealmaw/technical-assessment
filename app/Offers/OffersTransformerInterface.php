<?php
/**
 * Created by moe using PhpStorm.
 * Date: 5/13/18 9:36 AM
 */
namespace App\Offers;

use Illuminate\Support\Collection;


/**
 * Class ExpediaTransformer
 *
 * @package App\Offers\Expedia
 *
 * @author Mohammad Almawali <moealmaw@gmail.com>
 */
interface OffersTransformerInterface
{
    /**
     *
     * @param array $offers
     *
     * @return Collection
     */
    public function mapResponse(Array $offers): Collection;

    /**
     * @param array $params
     *
     * @return array
     */
    public function mapRequest(Array $params): array;
}