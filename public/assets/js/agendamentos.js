const botoesCancelar =
document.querySelectorAll(
'.btn-cancelar'
);

botoesCancelar.forEach(botao => {

    botao.addEventListener(
        'click',
        async () => {

        const id =
        botao.dataset.id;

        const confirmar =
        confirm(
            'Deseja cancelar o agendamento?'
        );

        if(!confirmar){

            return;

        }

        try{

            const resposta =
            await fetch(

                `cancelar-agendamento.php?id=${id}`,

                {
                    method:'GET'
                }

            );

            if(resposta.ok){

                alert(
                    'Agendamento cancelado!'
                );

                botao.parentElement
                .parentElement
                .remove();

            }

        }catch(error){

            console.error(error);

        }

    });

});