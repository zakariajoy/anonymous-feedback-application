<?
    $store_data=json_decode(file_get_contents('users.json'), true);
    $feedback_data=json_decode(file_get_contents('feedback.json'), true);
   
    if(isset($_POST['submit_btn']))
    {
        if (!empty($_POST['feedback'])){
            $new_feedback=[
                'link_id'=>$_POST['link_id'],
                'feedback'=>$_POST['feedback']
            ];
            $link_id=$_POST['link_id'];
            array_push($feedback_data, $new_feedback);
            if(file_put_contents('feedback.json', json_encode($feedback_data, JSON_PRETTY_PRINT))){
                $success = "Thank You ! Your Feedback Successfully Received.";
                header("Location:feedback.php?user=$link_id&success=$success");
                exit();
            }else{
                $dataerror = "Something went wrong, please try again";
                header("Location:feedback.php?user=$link_id&error=$dataerror");
                exit();
            }
        }
    }
    else{
        $get_id=$_GET['user'];
        if($get_id==''){
            $error_msg = "Wrong Feedback Link Please try Again!";
            header("location: index.php?error=$error_msg");
            exit();
        }
        else{
            $isRegisterUser=0;
            foreach ($store_data as $user) {
                if($user['link_id'] == $get_id){
                    $isRegisterUser=1;
                    $user_name=$user['name'];
                }
            }
            if($isRegisterUser==0){
                header("location: index.php?error=$error_msg");
                exit();
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TruthWhisper - Anonymous Feedback App</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<header class="bg-white">
    <nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
        <div class="flex lg:flex-1">
            <a href="./index.html" class="-m-1.5 p-1.5">
                <span class="sr-only">TruthWhisper</span>
                <span class="block font-bold text-lg bg-gradient-to-r from-blue-600 via-green-500 to-indigo-400 inline-block text-transparent bg-clip-text">TruthWhisper</span>
            </a>
        </div>
    </nav>
    <!-- Mobile menu, show/hide based on menu open state. -->
    <div class="lg:hidden" role="dialog" aria-modal="true">
        <!-- Background backdrop, show/hide based on slide-over state. -->
        <div class="fixed inset-0 z-10"></div>
        <div class="fixed inset-y-0 right-0 z-10 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
            <div class="flex items-center justify-between">
                <a href="./index.html" class="-m-1.5 p-1.5">
                    <span class="sr-only">TruthWhisper</span>
                    <span class="block font-bold text-xl bg-gradient-to-r from-blue-600 via-green-500 to-indigo-400 inline-block text-transparent bg-clip-text">TruthWhisper</span>
                </a>
                <button type="button" class="-m-2.5 rounded-md p-2.5 text-gray-700">
                    <span class="sr-only">Close menu</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</header>

<main class="">
    <div class="relative flex min-h-screen flex-col justify-center overflow-hidden bg-gray-50 py-6 sm:py-12">
        <img src="./images/beams.jpg" alt="" class="absolute top-1/2 left-1/2 max-w-none -translate-x-1/2 -translate-y-1/2" width="1308" />
        <div class="absolute inset-0 bg-[url(./images/grid.svg)] bg-center [mask-image:linear-gradient(180deg,white,rgba(255,255,255,0))]"></div>
        <div class="relative bg-white px-6 pt-10 pb-8 shadow-xl ring-1 ring-gray-900/5 sm:mx-auto sm:max-w-lg sm:rounded-lg sm:px-10">
            <div class="mx-auto max-w-xl">
                <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
                    <div class="mx-auto w-full max-w-xl text-center">
                        <h1 class="block text-center font-bold text-2xl bg-gradient-to-r from-blue-600 via-green-500 to-indigo-400 inline-block text-transparent bg-clip-text">TruthWhisper</h1>
                        <h3 class="text-gray-500 my-2">Want to ask something or share a feedback to "<?= $user_name ?>"?</h3>
                    </div>
                    <p class="success"><?php if(isset($_GET['success'])){ echo $_GET['success']; }?></p>
                    <p class="error"><?php if(isset($_GET['error'])){ echo $_GET['error']; }?></p>
                    <div class="mt-10 mx-auto w-full max-w-xl">
                        <form class="space-y-6" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                            <div>
                                <label for="feedback" class="block text-sm font-medium leading-6 text-gray-900">Don't hesitate, just do it!</label>
                                <div class="mt-2">
                                    <textarea required name="feedback" id="feedback" cols="30" rows="10" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                                    <input type="hidden" value="<?= $get_id ?>" name="link_id">
                                </div>
                            </div>

                            <div>
                                <button type="submit" name="submit_btn" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<footer class="bg-white">
    <div class="mx-auto max-w-7xl px-6 py-12 md:flex md:items-center justify-center lg:px-8">
        <p class="text-center text-xs leading-5 text-gray-500">&copy; 2024 TruthWhisper, Inc. All rights reserved.</p>
    </div>
</footer>

</body>
</html>