<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SdMedwatchPosition Entity
 *
 * @property int $id
 * @property string $medwatch_no
 * @property string $field_name
 * @property int $type
 * @property int $position_top
 * @property int $position_left
 * @property int $position_width
 * @property int $position_height
 * @property int $sd_field_id
 *
 * @property \App\Model\Entity\SdField $sd_field
 */
class SdMedwatchPosition extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'medwatch_no' => true,
        'field_name' => true,
        'type' => true,
        'position_top' => true,
        'position_left' => true,
        'position_width' => true,
        'position_height' => true,
        'sd_field_id' => true,
        'sd_field' => true
    ];
}
