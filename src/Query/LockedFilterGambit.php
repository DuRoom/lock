<?php

/*
 * This file is part of DuRoom.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace DuRoom\Lock\Query;

use DuRoom\Filter\FilterInterface;
use DuRoom\Filter\FilterState;
use DuRoom\Search\AbstractRegexGambit;
use DuRoom\Search\SearchState;
use Illuminate\Database\Query\Builder;

class LockedFilterGambit extends AbstractRegexGambit implements FilterInterface
{
    protected function getGambitPattern()
    {
        return 'is:locked';
    }

    protected function conditions(SearchState $searchState, array $matches, $negate)
    {
        $this->constrain($searchState->getQuery(), $negate);
    }

    public function getFilterKey(): string
    {
        return 'locked';
    }

    public function filter(FilterState $filterState, string $filterValue, bool $negate)
    {
        $this->constrain($filterState->getQuery(), $negate);
    }

    protected function constrain(Builder $query, bool $negate)
    {
        $query->where('is_locked', ! $negate);
    }
}
