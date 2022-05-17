<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */

namespace Roanja\Rjfilesmanager\Controller\Admin;

use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController as AbstractAdminController;
use Roanja\Rjfilesmanager\Grid\Definition\Factory\RjfileGridDefinitionFactory;
use Roanja\Rjfilesmanager\Grid\Filters\RjfileFilters;
use PrestaShopBundle\Security\Annotation\AdminSecurity;
use PrestaShopBundle\Security\Annotation\ModuleActivated;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class RjfileController.
 *
 * @ModuleActivated(moduleName="rj_filesmanager", redirectRoute="admin_module_manage")
 */
class RjfileController extends AbstractAdminController
{

    /**
     * List quotes
     *
     * @param QuoteFilters $filters
     *
     * @return Response
     */
    public function indexAction(RjfileFilters $filters)
    {
        $fileGridFactory = $this->get('roanja.rjfilesmanager.grid.factory.files');
        $fileGrid = $fileGridFactory->getGrid($filters);

        return $this->render(
            '@Modules/rj_filesmanager/views/templates/admin/index.html.twig',
            [
                'enableSidebar' => true,
                'layoutTitle' => $this->trans('File Manager', 'Modules.Rjfilesmanager.Admin'),
                'layoutHeaderToolbarBtn' => $this->getToolbarButtons(),
                'fileGrid' => $this->presentGrid($fileGrid),
            ]
        );
    }

    /**
     * Provides filters functionality.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function searchAction(Request $request)
    {
        /** @var ResponseBuilder $responseBuilder */
        $responseBuilder = $this->get('prestashop.bundle.grid.response_builder');

        return $responseBuilder->buildSearchResponse(
            $this->get('roanja.rjfilesmanager.grid.definition.factory.files'),
            $request,
            RjfileGridDefinitionFactory::GRID_ID,
            'admin_rjfilesmanager_list'
        );
    }

    public function createAction(Request $request)
    {
        $fileFormBuilder = $this->get('roanja.rjfilesmanager.form.identifiable_object.builder.rjfile_form_builder');
        $fileForm = $fileFormBuilder->getForm();
        $fileForm->handleRequest($request);

        $fileFormHandler = $this->get('roanja.rjfilesmanager.form.identifiable_object.handler.rjfile_form_handler');
        $result = $fileFormHandler->handle($fileForm);

        if (null !== $result->getIdentifiableObjectId()) {
            $this->addFlash(
                'success',
                $this->trans('Successful creation.', 'Admin.Notifications.Success')
            );

            return $this->redirectToRoute('admin_rjfilesmanager_list');
        }

        return $this->render('@Modules/rj_filesmanager/views/templates/admin/create.html.twig', [
            'fileForm' => $fileForm->createView(),
        ]);
    }

    /**
     * @return array[]
     */
    private function getToolbarButtons()
    {
        return [
            'add' => [
                'desc' => $this->trans('Add new quote', 'Modules.Rjfilesmanager.Admin'),
                'icon' => 'add_circle_outline',
                'href' => $this->generateUrl('admin_rjfilesmanager_create'),
            ]
        ];
    }
}