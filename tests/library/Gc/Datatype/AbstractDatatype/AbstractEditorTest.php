<?php
/**
 * This source file is part of GotCms.
 *
 * GotCms is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * GotCms is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License along
 * with GotCms. If not, see <http://www.gnu.org/licenses/lgpl-3.0.html>.
 *
 * PHP Version >=5.3
 *
 * @category Gc_Tests
 * @package  Library
 * @author   Pierre Rambaud (GoT) <pierre.rambaud86@gmail.com>
 * @license  GNU/LGPL http://www.gnu.org/licenses/lgpl-3.0.html
 * @link     http://www.got-cms.com
 */

namespace Gc\Datatype\AbstractDatatype;

use Gc\Datatype\Model as DatatypeModel;
use Gc\DocumentType\Model as DocumentTypeModel;
use Gc\Property\Model as PropertyModel;
use Gc\User\Model as UserModel;
use Gc\Tab\Model as TabModel;
use Gc\View\Model as ViewModel;
use Gc\Registry;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2012-10-17 at 20:40:10.
 *
 * @group Gc
 * @category Gc_Tests
 * @package  Library
 */
class AbstractEditorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AbstractEditor
     */
    protected $object;

    /**
     * @var TabModel
     */
    protected $tab;

    /**
     * @var UserModel
     */
    protected $user;

    /**
     * @var DocumentTypeModel
     */
     protected $documentType;

    /**
     * @var PropertyModel
     */
    protected $property;

    /**
     * @var ViewModel
     */
    protected $view;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @return void
     */
    protected function setUp()
    {
        $this->datatype = DatatypeModel::fromArray(
            array(
                'name' => 'AbstractEditorTest',
                'prevalue_value' => 's:18:"AbstractEditorTest";',
                'model' => 'AbstractEditorTest',
            )
        );
        $this->datatype->save();

        $this->view = ViewModel::fromArray(
            array(
                'name' => 'View Name',
                'identifier' => 'View identifier',
                'description' => 'View Description',
                'content' => 'View Content'
            )
        );
        $this->view->save();

        $this->user = UserModel::fromArray(
            array(
                'lastname' => 'User test',
                'firstname' => 'User test',
                'email' => 'pierre.rambaud86@gmail.com',
                'login' => 'test',
                'user_acl_role_id' => 1,
            )
        );
        $this->user->setPassword('test');
        $this->user->save();

        $this->documentType = DocumentTypeModel::fromArray(
            array(
                'name' => 'Document Type Name',
                'description' => 'Document Type description',
                'icon_id' => 1,
                'defaultview_id' => $this->view->getId(),
                'user_id' => $this->user->getId(),
            )
        );
        $this->documentType->save();

        $this->tab = TabModel::fromArray(
            array(
                'name' => 'TabTest',
                'description' => 'TabTest',
                'sort_order' => 1,
                'document_type_id' => $this->documentType->getId(),
            )
        );
        $this->tab->save();

        $this->property = PropertyModel::fromArray(
            array(
                'name' => 'DatatypeTest',
                'identifier' => 'DatatypeTest',
                'description' => 'DatatypeTest',
                'required' => false,
                'sort_order' => 1,
                'tab_id' => $this->tab->getId(),
                'datatype_id' => $this->datatype->getId(),
            )
        );

        $this->property->save();


        $mockDatatype = $this->getMockForAbstractClass('Gc\Datatype\AbstractDatatype');
        $application  = Registry::get('Application');
        $mockDatatype->setRequest($application->getServiceManager()->get('Request'));
        $mockDatatype->setRouter($application->getServiceManager()->get('Router'));
        $mockDatatype->setHelperManager($application->getServiceManager()->get('viewhelpermanager'));
        $mockDatatype->setProperty($this->property);
        $mockDatatype->load($this->datatype, 1);

        $this->object = $this->getMockForAbstractClass(
            'Gc\Datatype\AbstractDatatype\AbstractEditor',
            array($mockDatatype)
        );
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     *
     * @return void
     */
    protected function tearDown()
    {
        $this->property->delete();
        $this->datatype->delete();
        $this->tab->delete();
        $this->documentType->delete();
        $this->user->delete();
        $this->view->delete();
        unset($this->datatype);
        unset($this->property);
        unset($this->documentType);
        unset($this->tab);
        unset($this->user);
        unset($this->view);
        unset($this->object);
    }

    /**
     * Test
     *
     * @return void
     */
    public function testGetValue()
    {
        $this->object->setValue('test');
        $this->assertEquals('test', $this->object->getValue());
    }

    /**
     * Test
     *
     * @return void
     */
    public function testSetValue()
    {
        $this->object->setValue('test');
        $this->assertEquals('test', $this->object->getValue());
    }

    /**
     * Test
     *
     * @return void
     */
    public function testGetConfig()
    {
        $this->assertEquals('AbstractEditorTest', $this->object->getConfig());
    }

    /**
     * Test
     *
     * @return void
     */
    public function testSetConfig()
    {
        $this->object->setConfig('s:19:"AbstractEditorTest2";');
        $this->assertEquals('AbstractEditorTest2', $this->object->getConfig());
    }

    /**
     * Test
     *
     * @return void
     */
    public function testGetUploadUrl()
    {
        $this->assertEquals(
            '/admin/content/media/upload/document/1/property/' . $this->property->getId(),
            $this->object->getUploadUrl()
        );
    }

    /**
     * Test
     *
     * @return void
     */
    public function testGetName()
    {
        $this->assertEquals('datatype' . $this->property->getId(), $this->object->getName());
    }

    /**
     * Test
     *
     * @return void
     */
    public function testGetProperty()
    {
        $this->assertInstanceOf('Gc\Property\Model', $this->object->getProperty());
    }

    /**
     * Test
     *
     * @return void
     */
    public function testGetDatatype()
    {
        $this->assertInstanceOf('Gc\Datatype\AbstractDatatype', $this->object->getDatatype());
    }

    /**
     * Test
     *
     * @return void
     */
    public function testGetRequest()
    {
        $this->assertInstanceOf('Zend\Http\PhpEnvironment\Request', $this->object->getRequest());
    }

    /**
     * Test
     *
     * @return void
     */
    public function testRender()
    {
        $this->object->addPath(__DIR__ . '/../');
        $this->assertEquals('String' . PHP_EOL, $this->object->render('_files/template.phtml'));
    }

    /**
     * Test
     *
     * @return void
     */
    public function testAddPath()
    {
        $this->assertInstanceOf(get_class($this->object), $this->object->addPath(__DIR__));
    }

    /**
     * Test
     *
     * @return void
     */
    public function testGetHelper()
    {
        $this->assertInstanceOf('Gc\View\Helper\Partial', $this->object->getHelper('partial'));
    }
}
