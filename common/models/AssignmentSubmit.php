<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "assignment_submit".
 *
 * @property int $assign_sub_id
 * @property int $assign_id
 * @property int $std_id
 * @property string $attach_file
 * @property string $submit_date
 * @property string $status
 *
 * @property AssignmentRemarks[] $assignmentRemarks
 * @property AssignmentUpload $assign
 * @property Student $std
 */
class AssignmentSubmit extends \yii\db\ActiveRecord
{
    public $file_name;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'assignment_submit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() 
    {
        return [
            [['assign_id', 'std_id', 'submit_date', 'status', 'attach_file','file_name'], 'required'],
            [['assign_id', 'std_id'], 'integer'],
            [['submit_date'], 'safe'],
            [['status'], 'string'],
            [['assign_id'], 'exist', 'skipOnError' => true, 'targetClass' => AssignmentUpload::className(), 'targetAttribute' => ['assign_id' => 'assign_id']],
            [['std_id'], 'exist', 'skipOnError' => true, 'targetClass' => Student::className(), 'targetAttribute' => ['std_id' => 'std_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'assign_sub_id' => 'Assign Sub ID',
            'assign_id' => 'Assignment Title',
            'std_id' => 'Student',
            'file_name' => 'File Save As',
            'attach_file' => 'Attach File',
            'submit_date' => 'Submit Date',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[AssignmentRemarks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAssignmentRemarks()
    {
        return $this->hasMany(AssignmentRemarks::className(), ['assign_sub_id' => 'assign_sub_id']);
    }

    /**
     * Gets query for [[Assign]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAssign()
    {
        return $this->hasOne(AssignmentUpload::className(), ['assign_id' => 'assign_id']);
    }

    /**
     * Gets query for [[Std]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStd()
    {
        return $this->hasOne(Student::className(), ['std_id' => 'std_id']);
    }
}
