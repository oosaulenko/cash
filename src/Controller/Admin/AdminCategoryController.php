<?php


namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategoryController extends AdminBaseController {

    /**
     * @Route("/admin/category", name="admin_category")
     */
    public function index() {
        $for_render = parent::renderDefault();

        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();

        $for_render['title'] = 'Категории';
        $for_render['categories'] = $categories;

        return $this->render('admin/category/index.html.twig', $for_render);

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

}