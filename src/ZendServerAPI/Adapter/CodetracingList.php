<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * <http://www.rubber-duckling.net>
 */

namespace ZendServerAPI\Adapter;

class CodetracingList extends Adapter
{
    /**
     * @see \ZendServerAPI\Adapter\Adapter::parse()
     */
    public function parse ($xml = null)
    {
        if($xml === null)
            $xml = $this->getResponse()->getBody();

        $xml = simplexml_load_string($xml);

        $codetracingList = new \ZendServerAPI\DataTypes\CodetracingList();
        foreach ($xml->responseData->codeTracingList->codeTrace as $xmlCodetrace) {
            $codetrace = new \ZendServerAPI\DataTypes\CodeTrace();
            $codetrace->setId((string) $xmlCodetrace->id);
            $codetrace->setDate((string) $xmlCodetrace->date);
            $codetrace->setUrl((string) $xmlCodetrace->url);
            $codetrace->setCreatedBy((string) $xmlCodetrace->createdBy);
            $codetrace->setFileSize((string) $xmlCodetrace->fileSize);
            $codetrace->setApplicationId((string) $xmlCodetrace->applicationId);

            $codetracingList->addCodeTrace($codetrace);
        }

        return $codetracingList;
    }
}
