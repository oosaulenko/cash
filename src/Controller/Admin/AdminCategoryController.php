<?php


namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\CategoryMcc;
use App\Form\CategoryMccType;
use App\Form\CategoryType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategoryController extends AdminBaseController {

    /**
     * @Route("/admin/category", name="admin_category")
     */
    public function index(): Response {
        $forRender = parent::renderDefault();

        $categories = $this->getDoctrine()->getRepository(Category::class)->findBy([], ['priority' => 'DESC']);

        $forRender['title'] = 'Категории';
        $forRender['categories'] = $categories;

        return $this->render('admin/category/index.html.twig', $forRender);
    }

    /**
     * @Route("/admin/category/create", name="admin_category_create")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function create(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em->persist($category);
            $em->flush();
            $this->addFlash('success', 'Категория создана');
            return $this->redirectToRoute('admin_category');
        }

        $for_render = parent::renderDefault();
        $for_render['title'] = 'Создать категорию';
        $for_render['form'] = $form->createView();

        return $this->render('admin/category/form.html.twig', $for_render);
    }

    /**
     * @Route("/admin/category/update/{id}", name="admin_category_update")
     * @param int $id
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function update(int $id, Request $request) {
        $em = $this->getDoctrine()->getManager();
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            if($form->get('save')->isClicked()) {
                $this->addFlash('success', 'Категория обновлена');
            }
            if($form->get('delete')->isClicked()) {
                $em->remove($category);
                $this->addFlash('success', 'Категория удалена');
            }

            $em->flush();
            return $this->redirectToRoute('admin_category');
        }

        $for_render = parent::renderDefault();
        $for_render['title'] = 'Редактирование категории';
        $for_render['form'] = $form->createView();

        return $this->render('admin/category/form.html.twig', $for_render);
    }

    /**
     * @Route("/admin/category/mcc", name="admin_category_mcc")
     */
    public function indexMcc(): Response {
        $forRender = parent::renderDefault();

        $CategoriesMcc = $this->getDoctrine()->getRepository(CategoryMcc::class)->findAll();

        dump($CategoriesMcc);

        $forRender['title'] = 'MCC категорий';
        $forRender['categories'] = $CategoriesMcc;

        return $this->render('admin/category/mcc/index.html.twig', $forRender);
    }

    /**
     * @Route("/admin/category/mcc/create", name="admin_category_mcc_create")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function createMcc(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $categoryMcc = new CategoryMcc();
        $form = $this->createForm(CategoryMccType::class, $categoryMcc);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em->persist($categoryMcc);
            $em->flush();
            $this->addFlash('success', 'MCC-код добавлен');
            return $this->redirectToRoute('admin_category_mcc');
        }

        $for_render = parent::renderDefault();
        $for_render['title'] = 'Добавить MCC-код';
        $for_render['form'] = $form->createView();

        return $this->render('admin/category/mcc/form.html.twig', $for_render);
    }

    /**
     * @Route("/admin/category/mcc/update/{id}", name="admin_category_mcc_update")
     * @param int $id
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function updateMcc(int $id, Request $request) {
        $em = $this->getDoctrine()->getManager();
        $category = $this->getDoctrine()->getRepository(CategoryMcc::class)->find($id);
        $form = $this->createForm(CategoryMccType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'MCC-код обновлен');

            $em->flush();
            return $this->redirectToRoute('admin_category_mcc');
        }

        $forRender = parent::renderDefault();
        $forRender['title'] = 'Редактирование MCC-код';
        $forRender['form'] = $form->createView();
        $forRender['button_label'] = 'Обновить';

        return $this->render('admin/category/mcc/form.html.twig', $forRender);
    }

    /**
     * @Route("/{id}", name="admin_category_mcc_delete", methods="DELETE")
     * @param Request $request
     * @param CategoryMcc $categoryMcc
     * @return Response
     */
    public function deleteMcc(Request $request, CategoryMcc $categoryMcc): Response {

        if($this->isCsrfTokenValid('delete' . $categoryMcc->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($categoryMcc);
            $em->flush();
            $this->addFlash('danger', 'MCC-код удален');
        }

        return $this->redirectToRoute('admin_category_mcc');
    }

}