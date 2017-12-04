<?php

namespace Halite;

use Halite\Object\Circle;
use Halite\Object\Point;

class Geometry {

    /**
     * Distance between two points
     * @param Point $start
     * @param Point $end
     * @return float
     */
    static public function distance(Point $start, Point $end): float {
        $dx = $end->x() - $start->x();
        $dy = $end->y() - $start->y();
        return sqrt(pow($dx,2) + pow($dy,2));
    }

    /**
     * Angle in rad between two points
     * @param Point $start
     * @param Point $end
     * @return float
     */
    static public function angleInRad(Point $start, Point $end): float {
        $dx = $end->x() - $start->x();
        $dy = $end->y() - $start->y();
        $atan = atan2($dy, $dx);
        return $atan >= 0 ? $atan : ($atan + 2 * pi());
    }

    /**
     * Angle in degree between two points
     * @param Point $start
     * @param Point $end
     * @return float
     */
    static public function angleInDegree(Point $start, Point $end): float {
        return self::toDegree(self::angleInRad($start, $end));
    }

    /**
     * Given start and end positions,
     * @param Point $start
     * @param Point $end
     * @param float $degreeDelta
     * @return Point
     */
    static public function rotateEnd(Point $start, Point $end, $degreeDelta) {
        $distance = self::distance($start, $end);
        $angleDegree = self::angleInDegree($start, $end);

        $newAngleDegree = $angleDegree + $degreeDelta;

        $newAngleRad = self::toRad($newAngleDegree);

        $x = $start->x() + cos($newAngleRad) * $distance;
        $y = $start->y() + sin($newAngleRad) * $distance;

        return new Point($x, $y);
    }

    /**
     * Converts Rad to Degree
     * @param float $rad
     * @return float
     */
    static public function toDegree($rad): float {
        return $rad * 180 / pi();
    }

    /**
     * Converts Rad to Degree
     * @param float $degree
     * @return float
     */
    static public function toRad($degree): float {
        return $degree * pi() / 180;
    }

    /**
     * @param Point $start
     * @param Point $end
     * @param Circle $circle
     * @param int $padding
     * @return bool
     */
    static public function intersectsSegmentCircle(Point $start, Point $end, Circle $circle, $padding = 0) {
        $dx = $end->x() - $start->x();
        $dy = $end->y() - $start->y();

        $a = pow($dx,2) + pow($dy, 2);

        if ($a === 0) {
            return $start->distanceBetween($end) <= ($circle->radius() + $padding);
        }

        // intense!!!
        $b = -2 * (pow($start->x(),2) - $start->x() * $end->x() - $start->x() * $circle->x() + $end->x() *
                $circle->x() + pow($start->y(),2) - $start->y() * $end->y() - $start->y() * $circle->y() +
                $end->y() * $circle->y());

        $t = min(-$b / (2 * $a), 1.0);
        if ($t < 0) {
            return false;
        }

        $closestX = $start->x() + $dx * $t;
        $closestY = $start->y() + $dy * $t;
        $closestDistance = $circle->distanceBetween(new Point($closestX, $closestY));

        return $closestDistance <= $circle->radius() + $padding;
    }

    static public function pointOnLine(Point $start, Point $end, $distance) {
        $totalDistance = Geometry::distance($start, $end);
        if ($totalDistance <= $distance || $totalDistance == 0) {
            return $end;
        }
        $t = $distance / $totalDistance;
        $x = ((1 - $t) * $start->x()) + ($t * $end->x());
        $y = ((1 - $t) * $start->y()) + ($t * $end->y());
        return new Point($x, $y);
    }
}